<?php

namespace App\Services;

use App\Models\ResumeParse;
use App\Models\CandidateMatch;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\Employer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResumeScreeningService
{
    /**
     * Parse resume file and extract structured data
     */
    public function parseResume($file, $userId)
    {
        try {
            $extension = strtolower($file->getClientOriginalExtension());
            $content = $this->extractTextFromFile($file, $extension);
            
            if (empty(trim($content))) {
                Log::warning('Empty content extracted from resume', [
                    'file_name' => $file->getClientOriginalName(),
                    'extension' => $extension
                ]);
                return $this->createFailedResume($file, $userId, 'Could not extract text from file. Please try a different format.');
            }

            // Parse the content
            $parsedData = $this->parseWithAI($content);
            
            
            // Create resume parse record
            $resumeParse = ResumeParse::create([
                'user_id' => $userId,
                'file_path' => $file->store('resumes', 'public'),
                'file_name' => $file->getClientOriginalName(),
                'parsed_data' => $parsedData,
                'skills' => $parsedData['skills'] ?? [],
                'experience' => $parsedData['experience'] ?? [],
                'education' => $parsedData['education'] ?? [],
                'certifications' => $parsedData['certifications'] ?? [],
                'languages' => $parsedData['languages'] ?? [],
                'summary' => $parsedData['summary'] ?? null,
                'status' => 'completed',
                'parsed_at' => now(),
            ]);
            
            // Trigger matching for jobs
            $this->matchCandidateToJobs($resumeParse);
            
            return $resumeParse;
            
        } catch (\Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->createFailedResume($file, $userId, $e->getMessage());
        }
    }

    /**
     * Create a failed resume record
     */
    private function createFailedResume($file, $userId, $error)
    {
        return ResumeParse::create([
            'user_id' => $userId,
            'file_path' => $file->store('resumes', 'public'),
            'file_name' => $file->getClientOriginalName(),
            'status' => 'failed',
            'parsed_data' => ['error' => $error],
            'parsed_at' => now(),
        ]);
    }

    /**
     * Extract text from various file types
     */
    private function extractTextFromFile($file, $extension)
    {
        $path = $file->getPathname();
        
        switch ($extension) {
            case 'pdf':
                return $this->extractTextFromPDF($path);
            case 'docx':
                return $this->extractTextFromDOCX($path);
            case 'doc':
                return $this->extractTextFromDOC($path);
            case 'txt':
                return file_get_contents($path);
            default:
                throw new \Exception("Unsupported file format: {$extension}. Please upload PDF, DOC, DOCX, or TXT files.");
        }
    }

    /**
     * Extract text from PDF file
     */
    private function extractTextFromPDF($path)
    {
        // Try using Smalot PDF Parser
        if (class_exists(\Smalot\PdfParser\Parser::class)) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($path);
                $text = $pdf->getText();
                if (!empty(trim($text))) {
                    return $text;
                }
            } catch (\Exception $e) {
                Log::warning('Smalot PDF parser failed: ' . $e->getMessage());
            }
        }
        
        // Fallback: Use exec with pdftotext (if available)
        if (function_exists('exec')) {
            try {
                $output = shell_exec("pdftotext '{$path}' - 2>&1");
                if ($output && !empty(trim($output))) {
                    return $output;
                }
            } catch (\Exception $e) {
                Log::warning('pdftotext failed: ' . $e->getMessage());
            }
        }
        
        // Last resort: Read raw content and extract text
        try {
            $content = file_get_contents($path);
            // Remove binary data and keep only readable text
            $content = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $content);
            $content = preg_replace('/\s+/', ' ', $content);
            return trim($content);
        } catch (\Exception $e) {
            throw new \Exception('Could not extract text from PDF: ' . $e->getMessage());
        }
    }

    /**
     * Extract text from DOCX file
     */
    private function extractTextFromDOCX($path)
    {
        // Try using PhpOffice
        if (class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                        if (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $child) {
                                if (method_exists($child, 'getText')) {
                                    $text .= $child->getText() . "\n";
                                }
                            }
                        }
                    }
                }
                if (!empty(trim($text))) {
                    return $text;
                }
            } catch (\Exception $e) {
                Log::warning('PhpWord parser failed: ' . $e->getMessage());
            }
        }
        
        // Fallback: Extract using ZipArchive
        if (class_exists(\ZipArchive::class)) {
            try {
                $zip = new \ZipArchive();
                if ($zip->open($path) === true) {
                    $content = $zip->getFromName('word/document.xml');
                    $zip->close();
                    if ($content) {
                        // Remove XML tags
                        $content = strip_tags($content);
                        // Decode HTML entities
                        $content = html_entity_decode($content);
                        // Clean up whitespace
                        $content = preg_replace('/\s+/', ' ', $content);
                        return trim($content);
                    }
                }
            } catch (\Exception $e) {
                Log::warning('ZipArchive extraction failed: ' . $e->getMessage());
            }
        }
        
        throw new \Exception('Could not extract text from DOCX file.');
    }

    /**
     * Extract text from DOC file
     */
    private function extractTextFromDOC($path)
    {
        // Try using antiword
        if (function_exists('exec')) {
            try {
                $output = shell_exec("antiword '{$path}' 2>&1");
                if ($output && !empty(trim($output))) {
                    return $output;
                }
            } catch (\Exception $e) {
                Log::warning('antiword failed: ' . $e->getMessage());
            }
        }
        
        // Try using catdoc
        if (function_exists('exec')) {
            try {
                $output = shell_exec("catdoc '{$path}' 2>&1");
                if ($output && !empty(trim($output))) {
                    return $output;
                }
            } catch (\Exception $e) {
                Log::warning('catdoc failed: ' . $e->getMessage());
            }
        }
        
        // Fallback: Read raw content and extract text
        try {
            $content = file_get_contents($path);
            // Remove binary data and keep only readable text
            $content = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $content);
            $content = preg_replace('/\s+/', ' ', $content);
            return trim($content);
        } catch (\Exception $e) {
            throw new \Exception('Could not extract text from DOC file: ' . $e->getMessage());
        }
    }

    /**
     * Parse resume using AI or fallback
     */
    private function parseWithAI($content)
    {
        // Truncate content if too long
        $content = substr($content, 0, 8000);
        
        if (empty(trim($content))) {
            return $this->getDefaultParsedData();
        }
        
        // Try to use OpenAI if available
        try {
            if (class_exists(\OpenAI\Laravel\Facades\OpenAI::class)) {
                $prompt = "Parse the following resume and extract structured information in JSON format.
                
                Resume Content:
                {$content}
                
                Extract these fields as JSON:
                {
                    \"skills\": [\"skill1\", \"skill2\"],
                    \"experience\": [{\"title\": \"Job Title\", \"company\": \"Company Name\", \"years\": 3, \"description\": \"Description\"}],
                    \"education\": [{\"degree\": \"Degree Name\", \"field\": \"Field\", \"institution\": \"Institution\", \"year\": 2020}],
                    \"certifications\": [\"Certification1\"],
                    \"languages\": [\"Language1\"],
                    \"summary\": \"Professional summary\",
                    \"years_of_experience\": 5
                }
                
                Return ONLY valid JSON, no other text.";
                
                $response = \OpenAI::chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a professional resume parser. Extract information accurately.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 2000,
                ]);
                
                $content = $response->choices[0]->message->content;
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data) {
                        return array_merge($this->getDefaultParsedData(), $data);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('AI parsing failed: ' . $e->getMessage());
        }
        
        // Fallback to basic parsing
        return $this->fallbackParsing($content);
    }

    /**
     * Get default parsed data structure
     */
    private function getDefaultParsedData()
    {
        return [
            'skills' => [],
            'experience' => [],
            'education' => [],
            'certifications' => [],
            'languages' => [],
            'summary' => '',
            'years_of_experience' => 0,
        ];
    }

    /**
     * Fallback parsing when AI is unavailable
     */
    private function fallbackParsing($content)
    {
        $skills = $this->extractSkills($content);
        $experience = $this->extractExperience($content);
        $education = $this->extractEducation($content);
        
        return [
            'skills' => $skills,
            'experience' => $experience,
            'education' => $education,
            'certifications' => [],
            'languages' => [],
            'summary' => substr($content, 0, 500),
            'years_of_experience' => count($experience),
        ];
    }

    /**
     * Extract skills from text
     */
    private function extractSkills($text)
    {
        $commonSkills = [
            'PHP', 'Laravel', 'Python', 'JavaScript', 'React', 'Vue', 'Angular',
            'Node.js', 'Java', 'Spring Boot', 'C#', '.NET', 'Ruby', 'Rails',
            'SQL', 'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Docker', 'Kubernetes',
            'AWS', 'Azure', 'GCP', 'DevOps', 'CI/CD', 'Git', 'Linux', 'Nginx',
            'Apache', 'REST API', 'GraphQL', 'WebSocket', 'Microservices',
            'Agile', 'Scrum', 'Project Management', 'Leadership', 'Communication',
            'Team Management', 'Problem Solving', 'Critical Thinking',
            'HTML', 'CSS', 'TypeScript', 'Bootstrap', 'Tailwind', 'jQuery'
        ];
        
        $foundSkills = [];
        foreach ($commonSkills as $skill) {
            if (stripos($text, $skill) !== false) {
                $foundSkills[] = $skill;
            }
        }
        
        return $foundSkills;
    }

    /**
     * Extract experience from text
     */
    private function extractExperience($text)
    {
        $experience = [];
        
        // Find years of experience
        preg_match_all('/(\d{4})\s*[-–]\s*(?:\d{4}|present|current)/i', $text, $matches);
        
        if (!empty($matches[0])) {
            foreach ($matches[0] as $match) {
                preg_match('/(\d{4})/', $match, $yearMatch);
                if (isset($yearMatch[1])) {
                    $experience[] = [
                        'title' => 'Position',
                        'company' => 'Company',
                        'years' => date('Y') - (int)$yearMatch[1],
                        'description' => '',
                    ];
                }
            }
        }
        
        // If no experience found, try to find job titles
        if (empty($experience)) {
            $jobTitles = ['developer', 'engineer', 'manager', 'lead', 'architect', 'analyst'];
            foreach ($jobTitles as $title) {
                if (stripos($text, $title) !== false) {
                    $experience[] = [
                        'title' => ucfirst($title),
                        'company' => 'Unknown Company',
                        'years' => 1,
                        'description' => '',
                    ];
                    break;
                }
            }
        }
        
        return $experience;
    }

    /**
     * Extract education from text
     */
    private function extractEducation($text)
    {
        $education = [];
        $degrees = ['B.Sc', 'M.Sc', 'MBA', 'Ph.D', 'BS', 'MS', 'BA', 'MA', 'B.Tech', 'M.Tech'];
        
        foreach ($degrees as $degree) {
            if (stripos($text, $degree) !== false) {
                $education[] = [
                    'degree' => $degree,
                    'field' => 'Unknown',
                    'institution' => 'Unknown Institution',
                    'year' => null,
                ];
                break;
            }
        }
        
        return $education;
    }

    /**
     * Match candidate to all relevant jobs
     */
    public function matchCandidateToJobs(ResumeParse $resumeParse)
    {
        $userSkills = $resumeParse->skills ?? [];
        $userExperience = $resumeParse->experience ?? [];
        $userEducation = $resumeParse->education ?? [];
        $yearsExperience = $resumeParse->parsed_data['years_of_experience'] ?? 0;
        
        // Get all active jobs
        $jobs = JobPost::where('status', 'published')->get();
        
        foreach ($jobs as $job) {
            $this->matchSingleJob($resumeParse, $job, [
                'skills' => $userSkills,
                'experience' => $userExperience,
                'education' => $userEducation,
                'years_experience' => $yearsExperience,
            ]);
        }
    }

    /**
     * Match a single candidate to a specific job
     */
    public function matchSingleJob($resumeParse, JobPost $job, $candidateData)
    {
        // Extract job requirements from description
        $jobRequirements = $this->extractRequirementsFromDescription($job);
        
        // Calculate match scores
        $scores = $this->calculateMatchScores($jobRequirements, $candidateData);
        
        // Find or create application
        $application = Application::firstOrCreate([
            'job_post_id' => $job->id,
            'applicant_id' => $resumeParse->user_id,
        ], [
            'status' => 'pending',
            'applied_at' => now(),
        ]);
        
        // Create or update candidate match
        $match = CandidateMatch::updateOrCreate([
            'job_post_id' => $job->id,
            'application_id' => $application->id,
            'resume_parse_id' => $resumeParse->id,
        ], [
            'overall_score' => $scores['overall'],
            'skills_match_score' => $scores['skills_match'],
            'experience_match_score' => $scores['experience_match'],
            'education_match_score' => $scores['education_match'],
            'certifications_match_score' => 0,
            'matched_skills' => $scores['matched_skills'],
            'missing_skills' => $scores['missing_skills'],
            'matching_experience' => $scores['matching_experience'],
            'matching_education' => $scores['matching_education'],
            'match_details' => $scores['match_details'],
            'tier' => $this->getTier($scores['overall']),
            'is_recommended' => $scores['overall'] >= 70,
            'matched_at' => now(),
        ]);
        
        // Auto-shortlist top candidates
        if ($scores['overall'] >= 80) {
            $match->update(['is_shortlisted' => true]);
            $application->update(['status' => 'shortlisted']);
        }
        
        return $match;
    }

    /**
     * Extract requirements from job description
     */
    private function extractRequirementsFromDescription(JobPost $job)
    {
        $text = ($job->description ?? '') . ' ' . ($job->requirements ?? '');
        
        // Extract skills from job description
        $skills = $this->extractSkills($text);
        
        // Extract min experience
        $minExperience = 0;
        if (preg_match('/(\d+)\s*\+\s*years?/i', $text, $matches)) {
            $minExperience = (int) $matches[1];
        } elseif (preg_match('/(\d+)\s*years?/i', $text, $matches)) {
            $minExperience = (int) $matches[1];
        }
        
        return [
            'skills' => $skills,
            'preferred_skills' => [],
            'min_experience' => $minExperience,
            'education' => [],
            'certifications' => [],
        ];
    }

    /**
     * Calculate match scores
     */
    private function calculateMatchScores($jobRequirements, $candidateData)
    {
        $requiredSkills = $jobRequirements['skills'] ?? [];
        $candidateSkills = $candidateData['skills'] ?? [];
        
        // Skills matching
        $matchedSkills = array_intersect($candidateSkills, $requiredSkills);
        $missingSkills = array_diff($requiredSkills, $candidateSkills);
        
        $skillsMatchScore = !empty($requiredSkills) 
            ? (count($matchedSkills) / count($requiredSkills)) * 100 
            : 100;
        
        // Experience matching
        $requiredExp = $jobRequirements['min_experience'] ?? 0;
        $candidateExp = $candidateData['years_experience'] ?? 0;
        
        $experienceMatchScore = $requiredExp > 0 
            ? min(($candidateExp / $requiredExp) * 100, 100)
            : 100;
        
        // Education matching (simplified)
        $educationMatchScore = !empty($candidateData['education']) ? 100 : 50;
        
        // Calculate overall score
        $weights = [
            'skills' => 0.60,
            'experience' => 0.30,
            'education' => 0.10,
        ];
        
        $overallScore = 
            ($skillsMatchScore * $weights['skills']) +
            ($experienceMatchScore * $weights['experience']) +
            ($educationMatchScore * $weights['education']);
        
        return [
            'overall' => round($overallScore, 2),
            'skills_match' => round($skillsMatchScore, 2),
            'experience_match' => round($experienceMatchScore, 2),
            'education_match' => round($educationMatchScore, 2),
            'matched_skills' => array_values($matchedSkills),
            'missing_skills' => array_values($missingSkills),
            'matching_experience' => $candidateExp,
            'matching_education' => $candidateData['education'] ?? [],
            'match_details' => [
                'total_skills_required' => count($requiredSkills),
                'skills_matched' => count($matchedSkills),
                'skills_missing' => count($missingSkills),
                'experience_required' => $requiredExp,
                'experience_has' => $candidateExp,
            ],
        ];
    }

    /**
     * Get candidate tier
     */
    private function getTier($score)
    {
        if ($score >= 90) return 'A';
        if ($score >= 75) return 'B';
        if ($score >= 60) return 'C';
        return 'D';
    }

    /**
     * Get top candidates for a job
     */
    public function getTopCandidates($jobId, $limit = 20)
    {
        return CandidateMatch::with(['application', 'resumeParse.user'])
            ->where('job_post_id', $jobId)
            ->orderBy('overall_score', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get match summary for employer
     */
    public function getMatchSummary($employerId)
    {
        $jobs = JobPost::where('employer_id', $employerId)->pluck('id');
        
        return [
            'total_matches' => CandidateMatch::whereIn('job_post_id', $jobs)->count(),
            'highly_recommended' => CandidateMatch::whereIn('job_post_id', $jobs)
                ->where('tier', 'A')
                ->count(),
            'shortlisted' => CandidateMatch::whereIn('job_post_id', $jobs)
                ->where('is_shortlisted', true)
                ->count(),
            'average_score' => CandidateMatch::whereIn('job_post_id', $jobs)
                ->avg('overall_score'),
            'top_tiers' => [
                'A' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'A')->count(),
                'B' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'B')->count(),
                'C' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'C')->count(),
                'D' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'D')->count(),
            ],
        ];
    }
}