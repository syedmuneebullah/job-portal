<?php

namespace App\Services;

use App\Models\ResumeParse;
use App\Models\CandidateMatch;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResumeScreeningService
{
    /**
     * Parse resume file and extract structured data.
     * ALWAYS returns a ResumeParse model.
     */
    public function parseResume($file, $userId)
    {
        try {
            $extension = strtolower($file->getClientOriginalExtension());
            $content   = $this->extractTextFromFile($file, $extension);

            if (empty(trim($content))) {
                Log::warning('Empty content extracted', ['file' => $file->getClientOriginalName()]);
                return $this->createFailedResume($file, $userId, 'Could not extract text from file.');
            }

            // Clean and normalize the raw text
            $cleanText = $this->normalizeText($content);

            // Try AI first; if sparse, fall back to smart regex
            $parsedData = $this->parseWithAI($cleanText);

            if ($this->isParsedDataSparse($parsedData)) {
                Log::info('AI parse sparse, running smart fallback');
                $parsedData = $this->smartParse($cleanText, $parsedData);
            }

            $resumeParse = ResumeParse::create([
                'user_id'        => $userId,
                'file_path'      => $file->store('resumes', 'public'),
                'file_name'      => $file->getClientOriginalName(),
                'parsed_data'    => $parsedData,
                'skills'         => $parsedData['skills'] ?? [],
                'experience'     => $parsedData['experience'] ?? [],
                'education'      => $parsedData['education'] ?? [],
                'certifications' => $parsedData['certifications'] ?? [],
                'languages'      => $parsedData['languages'] ?? [],
                'summary'        => $parsedData['summary'] ?? null,
                'status'         => 'completed',
                'parsed_at'      => now(),
            ]);

            try {
                $this->matchCandidateToJobs($resumeParse);
            } catch (\Exception $e) {
                Log::warning('Job matching failed: ' . $e->getMessage());
            }

            return $resumeParse;

        } catch (\Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage(), [
                'file'  => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->createFailedResume($file, $userId, $e->getMessage());
        }
    }

    /**
     * Detect if parsed data is too sparse and needs smart fallback.
     */
    private function isParsedDataSparse(array $data): bool
    {
        $skillsCount     = count($data['skills'] ?? []);
        $experienceCount = count($data['experience'] ?? []);
        $educationCount  = count($data['education'] ?? []);

        return $skillsCount < 3 || $experienceCount < 2 || $educationCount < 2;
    }

    /**
     * Normalize text: collapse whitespace, fix common PDF issues.
     */
    private function normalizeText(string $text): string
    {
        $text = str_replace(["\xC2\xA0", "\u{00A0}"], ' ', $text);
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);
        $text = preg_replace("/[ \t]{2,}/", ' ', $text);
        return trim($text);
    }

    /**
     * Smart fallback: section-aware extraction + better regex.
     */
    private function smartParse(string $text, array $existing = []): array
    {
        $sections = $this->splitIntoSections($text);

        $skills     = $this->mergeUnique($existing['skills'] ?? [], $this->extractSkills($text));
        $experience = !empty($existing['experience']) && count($existing['experience']) >= 2
                        ? $existing['experience']
                        : $this->extractExperienceFromSections($sections, $text);
        $education  = !empty($existing['education']) && count($existing['education']) >= 2
                        ? $existing['education']
                        : $this->extractEducationFromSections($sections, $text);
        $contact    = $this->extractContactInfo($text);
        $summary    = $this->extractSummary($sections, $text);
        $certs      = $this->extractCertifications($text);
        $languages  = $this->extractLanguages($text);

        $yearsExp = $this->estimateYearsOfExperience($experience, $text);

        return [
            'name'                => $contact['name']  ?? ($existing['name']  ?? null),
            'email'               => $contact['email'] ?? ($existing['email'] ?? null),
            'phone'               => $contact['phone'] ?? ($existing['phone'] ?? null),
            'location'            => $contact['location'] ?? ($existing['location'] ?? null),
            'title'               => $this->extractJobTitle($text) ?? ($existing['title'] ?? null),
            'skills'              => array_values(array_unique($skills)),
            'experience'          => $experience,
            'education'           => $education,
            'certifications'      => $certs,
            'languages'           => $languages,
            'summary'             => $summary ?: ($existing['summary'] ?? ''),
            'years_of_experience' => $yearsExp,
        ];
    }

    /**
     * Split resume into named sections based on common headers.
     */
    private function splitIntoSections(string $text): array
    {
        $sections = [
            'contact'        => '',
            'summary'        => '',
            'skills'         => '',
            'experience'     => '',
            'education'      => '',
            'certifications' => '',
            'languages'      => '',
            'other'          => '',
        ];

        $headers = [
            'summary'        => '/^(profile|summary|about\s*me|professional\s*summary|objective)\s*$/im',
            'skills'         => '/^(skills|technical\s*skills|technical\s*stacks?|core\s*competencies|expertise|technologies)\s*$/im',
            'experience'     => '/^(work\s*experience|experience|employment|professional\s*experience|career\s*history)\s*$/im',
            'education'      => '/^(education|academic|qualifications?|academics)\s*$/im',
            'certifications' => '/^(certifications?|courses?|licenses?|training)\s*$/im',
            'languages'      => '/^(languages?)\s*$/im',
            'contact'        => '/^(contact|contact\s*info(rmation)?)\s*$/im',
        ];

        $positions = [];
        foreach ($headers as $key => $pattern) {
            if (preg_match_all($pattern, $text, $m, PREG_OFFSET_CAPTURE)) {
                foreach ($m[0] as $match) {
                    $positions[] = [
                        'key'    => $key,
                        'offset' => $match[1],
                        'length' => strlen($match[0]),
                    ];
                }
            }
        }

        usort($positions, fn($a, $b) => $a['offset'] <=> $b['offset']);

        $count = count($positions);
        for ($i = 0; $i < $count; $i++) {
            $start = $positions[$i]['offset'] + $positions[$i]['length'];
            $end   = ($i + 1 < $count) ? $positions[$i + 1]['offset'] : strlen($text);
            $body  = trim(substr($text, $start, $end - $start));
            $sections[$positions[$i]['key']] .= "\n" . $body;
        }

        if (!empty($positions)) {
            $firstOffset = $positions[0]['offset'];
            $sections['contact'] = trim(substr($text, 0, $firstOffset)) . "\n" . $sections['contact'];
        } else {
            $sections['contact'] = $text;
        }

        return array_map('trim', $sections);
    }

    /**
     * Extract contact info from text.
     */
    private function extractContactInfo(string $text): array
    {
        $result = ['name' => null, 'email' => null, 'phone' => null, 'location' => null];

        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $m)) {
            $result['email'] = $m[0];
        }

        if (preg_match('/(\+?\d{1,4}[\s\-]?\(?\d{2,4}\)?[\s\-]?\d{3,4}[\s\-]?\d{4,7})/', $text, $m)) {
            $result['phone'] = trim($m[0]);
        }

        if (preg_match('/([A-Z][a-zA-Z\s]+,\s*[A-Z][a-zA-Z\s]+)/', $text, $m)) {
            $result['location'] = trim($m[1]);
        }

        $lines = preg_split("/\n/", $text);
        foreach (array_slice($lines, 0, 8) as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            if (strlen($line) > 60) continue;
            if (preg_match('/[@\d\(\)]/', $line)) continue;
            if (preg_match('/^[A-Z][a-zA-Z\-\']+(\s+[A-Z][a-zA-Z\-\']+){1,3}$/', $line)) {
                $result['name'] = $line;
                break;
            }
        }

        return $result;
    }

    /**
     * Extract job title from the top of the resume.
     */
    private function extractJobTitle(string $text): ?string
    {
        $lines  = preg_split("/\n/", $text);
        $titles = [
            'senior software engineer', 'software engineer', 'full stack developer',
            'senior full stack developer', 'laravel developer', 'php developer',
            'senior laravel developer', 'web developer', 'developer',
            'project manager', 'product manager', 'designer', 'data analyst',
        ];
        foreach (array_slice($lines, 0, 10) as $line) {
            $lower = strtolower(trim($line));
            foreach ($titles as $t) {
                if (str_contains($lower, $t)) {
                    return ucwords($t);
                }
            }
        }
        return null;
    }

    /**
     * Extract summary/profile section.
     */
    private function extractSummary(array $sections, string $text): string
    {
        $summary = $sections['summary'] ?? '';
        if (!empty($summary)) {
            $summary = preg_replace('/^(profile|summary|about\s*me|objective)\s*/i', '', $summary);
            return trim(substr($summary, 0, 800));
        }
        return '';
    }

    /**
     * Extract certifications.
     */
    private function extractCertifications(string $text): array
    {
        $certs = [];
        if (preg_match('/(certified|certification|certificate)[^\n\.]*/i', $text, $m)) {
            $certs[] = trim($m[0]);
        }
        return array_values(array_unique($certs));
    }

    /**
     * Extract languages.
     */
    private function extractLanguages(string $text): array
    {
        $known = ['English', 'Urdu', 'Arabic', 'Hindi', 'French', 'Spanish', 'Chinese', 'Malay'];
        $found = [];
        foreach ($known as $lang) {
            if (preg_match('/\b' . preg_quote($lang, '/') . '\b/i', $text)) {
                $found[] = $lang;
            }
        }
        return $found;
    }

    /**
     * Estimate years of experience.
     */
    private function estimateYearsOfExperience(array $experience, string $text): int
    {
        if (preg_match('/(\d+)\s*\+?\s*years?\s*(of)?\s*experience/i', $text, $m)) {
            return (int) $m[1];
        }

        $total = 0;
        foreach ($experience as $job) {
            $total += (int) ($job['years'] ?? 0);
        }
        return min($total, 40);
    }

    /**
     * Extract experience entries from sections.
     */
    private function extractExperienceFromSections(array $sections, string $text): array
    {
        $body = $sections['experience'] ?? $text;
        if (empty($body)) return [];

        $experience = [];
        $lines = preg_split("/\n/", $body);

        $jobPatterns = [
            '/([A-Z][a-zA-Z\s\/]+?)\s+((?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+\d{4})\s*[-–]\s*((?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+\d{4}|Present|Current)\s+([^\n]+)/i',
            '/([A-Z][a-zA-Z\s\/]+?)\s+(\d{4})\s*[-–]\s*(\d{4}|Present)\s+([^\n]+)/i',
        ];

        foreach ($jobPatterns as $pattern) {
            if (preg_match_all($pattern, $body, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $title   = trim($m[1] ?? 'Unknown');
                    $start   = trim($m[2] ?? '');
                    $end     = trim($m[3] ?? '');
                    $company = trim($m[4] ?? 'Unknown');

                    if (strlen($title) > 60) continue;

                    $years = $this->calculateYears($start, $end);

                    $experience[] = [
                        'title'       => $title,
                        'company'     => $company,
                        'location'    => $this->extractLocationFromCompany($company),
                        'start_date'  => $start,
                        'end_date'    => $end,
                        'years'       => $years,
                        'description' => '',
                    ];
                }
            }
            if (!empty($experience)) break;
        }

        if (empty($experience)) {
            foreach ($lines as $i => $line) {
                $line = trim($line);
                if (empty($line)) continue;

                if (preg_match('/^([A-Z][a-zA-Z\s]+?)\s+(?:at|@)\s+([A-Z][^\n]+)$/i', $line, $m)) {
                    $experience[] = [
                        'title'       => trim($m[1]),
                        'company'     => trim($m[2]),
                        'location'    => '',
                        'years'       => 1,
                        'description' => trim($lines[$i + 1] ?? ''),
                    ];
                } elseif (preg_match('/^([A-Z][a-zA-Z\s]+(?:Developer|Engineer|Manager|Designer|Analyst|Lead|Architect|Faculty|Consultant|Intern)[a-zA-Z\s]*)$/i', $line)) {
                    $nextLine = trim($lines[$i + 1] ?? '');
                    if ($nextLine && preg_match('/^[A-Z]/', $nextLine)) {
                        $experience[] = [
                            'title'       => $line,
                            'company'     => $nextLine,
                            'location'    => '',
                            'years'       => 1,
                            'description' => trim($lines[$i + 2] ?? ''),
                        ];
                    }
                }
            }
        }

        return array_slice($experience, 0, 15);
    }

    /**
     * Calculate years between two date strings.
     */
    private function calculateYears(string $start, string $end): int
    {
        try {
            $startTs = $this->parseDate($start);
            $endTs   = $this->parseDate($end) ?: time();
            if (!$startTs) return 1;
            return max(1, (int) round(($endTs - $startTs) / (365 * 24 * 3600)));
        } catch (\Exception $e) {
            return 1;
        }
    }

    /**
     * Parse date strings.
     */
    private function parseDate(string $str): ?int
    {
        $str = trim($str);
        if (empty($str)) return null;
        if (preg_match('/present|current/i', $str)) return time();

        if (preg_match('/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+(\d{4})/i', $str, $m)) {
            return strtotime("{$m[1]} 1, {$m[2]}");
        }
        if (preg_match('/^(\d{4})$/', $str, $m)) {
            return strtotime("Jan 1, {$m[1]}");
        }
        return null;
    }

    /**
     * Guess location from company string.
     */
    private function extractLocationFromCompany(string $company): string
    {
        if (preg_match('/,\s*([^,]+,\s*[^,]+)$/', $company, $m)) {
            return trim($m[1]);
        }
        return '';
    }

    /**
     * Extract education entries from sections.
     */
    private function extractEducationFromSections(array $sections, string $text): array
    {
        $body = $sections['education'] ?? '';
        if (empty($body)) $body = $text;

        $education = [];
        $lines     = preg_split("/\n/", $body);

        $degreeKeywords = [
            'bachelor', 'bachelors', 'master', 'masters', 'phd', 'ph.d',
            'bs', 'ms', 'ba', 'ma', 'bsc', 'msc', 'b.sc', 'm.sc',
            'mba', 'b.tech', 'm.tech', 'diploma', 'certificate', 'certified',
            'intermediate', 'matriculation', 'matric', 'high school',
        ];

        $institutionKeywords = [
            'university', 'college', 'institute', 'school', 'academy', 'aptech',
            'lincoln', 'govt', 'government', 'national',
        ];

        for ($i = 0; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) continue;
            $lower = strtolower($line);

            $isDegree = false;
            foreach ($degreeKeywords as $kw) {
                if (str_contains($lower, $kw)) { $isDegree = true; break; }
            }
            if (!$isDegree) continue;

            $institution = '';
            $field       = '';
            $year        = null;

            if (str_contains($line, '|')) {
                $parts = array_map('trim', explode('|', $line));
                $line        = $parts[0] ?? $line;
                $institution = $parts[1] ?? '';
            } elseif (str_contains($line, ' - ')) {
                $parts = array_map('trim', explode(' - ', $line));
                $line        = $parts[0] ?? $line;
                $institution = $parts[1] ?? '';
            }

            if (empty($institution)) {
                for ($j = $i + 1; $j < min($i + 3, count($lines)); $j++) {
                    $next = trim($lines[$j]);
                    if (empty($next)) continue;
                    $nextLower = strtolower($next);
                    foreach ($institutionKeywords as $kw) {
                        if (str_contains($nextLower, $kw)) {
                            $institution = $next;
                            break 2;
                        }
                    }
                }
            }

            if (preg_match('/\b(19|20)\d{2}\b/', $line . ' ' . $institution, $m)) {
                $year = (int) $m[0];
            }

            if (preg_match('/(?:in|of)\s+([A-Z][a-zA-Z\s]+)/', $line, $m)) {
                $field = trim($m[1]);
            }

            $education[] = [
                'degree'      => $this->normalizeDegree($line),
                'field'       => $field,
                'institution' => $institution ?: 'Unknown Institution',
                'year'        => $year,
            ];
        }

        $seen   = [];
        $unique = [];
        foreach ($education as $edu) {
            $key = strtolower($edu['degree'] . '|' . $edu['institution']);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $unique[]   = $edu;
            }
        }

        return array_slice($unique, 0, 10);
    }

    /**
     * Normalize degree string.
     */
    private function normalizeDegree(string $line): string
    {
        $map = [
            'bachelor'        => "Bachelor's Degree",
            'bachelors'       => "Bachelor's Degree",
            'master'          => "Master's Degree",
            'masters'         => "Master's Degree",
            'phd'             => 'PhD',
            'ph.d'            => 'PhD',
            'mba'             => 'MBA',
            'bs'              => 'BS',
            'ms'              => 'MS',
            'bsc'             => 'BSc',
            'msc'             => 'MSc',
            'b.sc'            => 'BSc',
            'm.sc'            => 'MSc',
            'b.tech'          => 'B.Tech',
            'm.tech'          => 'M.Tech',
            'diploma'         => 'Diploma',
            'advance diploma' => 'Advanced Diploma',
            'intermediate'    => 'Intermediate',
            'matric'          => 'Matriculation',
            'matriculation'   => 'Matriculation',
            'certified'       => 'Certification',
            'certificate'     => 'Certificate',
        ];
        $lower = strtolower($line);
        foreach ($map as $key => $val) {
            if (str_contains($lower, $key)) return $val;
        }
        return trim(substr($line, 0, 80));
    }

    /**
     * Create a failed resume record.
     */
    private function createFailedResume($file, $userId, $error)
    {
        $path = null;
        try { $path = $file->store('resumes', 'public'); } catch (\Exception $e) {}

        return ResumeParse::create([
            'user_id'     => $userId,
            'file_path'   => $path,
            'file_name'   => $file->getClientOriginalName(),
            'status'      => 'failed',
            'parsed_data' => ['error' => $error],
            'parsed_at'   => now(),
        ]);
    }

    /**
     * Extract text from file.
     */
    private function extractTextFromFile($file, $extension)
    {
        $path = $file->getPathname();
        switch ($extension) {
            case 'pdf':  return $this->extractTextFromPDF($path);
            case 'docx': return $this->extractTextFromDOCX($path);
            case 'doc':  return $this->extractTextFromDOC($path);
            case 'txt':  return file_get_contents($path);
            default: throw new \Exception("Unsupported file format: {$extension}.");
        }
    }

    /**
     * Extract text from PDF.
     */
    private function extractTextFromPDF($path)
    {
        if (class_exists(\Smalot\PdfParser\Parser::class)) {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf    = $parser->parseFile($path);
                $text   = $pdf->getText();
                if (!empty(trim($text))) return $text;
            } catch (\Exception $e) {
                Log::warning('Smalot PDF parser failed: ' . $e->getMessage());
            }
        }

        if (function_exists('shell_exec')) {
            try {
                $output = shell_exec("pdftotext " . escapeshellarg($path) . " - 2>&1");
                if ($output && !empty(trim($output))) return $output;
            } catch (\Exception $e) {}
        }

        $content = file_get_contents($path);
        $content = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $content);
        return trim(preg_replace('/\s+/', ' ', $content));
    }

    /**
     * Extract text from DOCX.
     */
    private function extractTextFromDOCX($path)
    {
        if (class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) $text .= $element->getText() . "\n";
                        if (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $child) {
                                if (method_exists($child, 'getText')) $text .= $child->getText() . "\n";
                            }
                        }
                    }
                }
                if (!empty(trim($text))) return $text;
            } catch (\Exception $e) {}
        }

        if (class_exists(\ZipArchive::class)) {
            $zip = new \ZipArchive();
            if ($zip->open($path) === true) {
                $content = $zip->getFromName('word/document.xml');
                $zip->close();
                if ($content) {
                    $content = html_entity_decode(strip_tags($content));
                    return trim(preg_replace('/\s+/', ' ', $content));
                }
            }
        }

        throw new \Exception('Could not extract text from DOCX.');
    }

    /**
     * Extract text from DOC.
     */
    private function extractTextFromDOC($path)
    {
        if (function_exists('shell_exec')) {
            foreach (['antiword', 'catdoc'] as $tool) {
                $output = @shell_exec("$tool " . escapeshellarg($path) . " 2>&1");
                if ($output && !empty(trim($output))) return $output;
            }
        }

        $content = file_get_contents($path);
        $content = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $content);
        return trim(preg_replace('/\s+/', ' ', $content));
    }

    /**
     * Parse resume using AI (if available).
     */
    private function parseWithAI($content)
    {
        $content = substr($content, 0, 12000);

        if (empty(trim($content))) return $this->getDefaultParsedData();

        try {
            if (class_exists(\OpenAI\Laravel\Facades\OpenAI::class)) {
                $prompt = <<<PROMPT
You are an expert resume parser. Extract structured JSON from the resume below.

STRICT RULES:
1. Do NOT invent data. If a field is missing, use null or [].
2. Extract ALL work experiences (do not stop at 1 or 2).
3. Extract ALL education entries.
4. Extract the candidate's full name, email, phone, location, and current job title.
5. Skills: include technical AND soft skills found in the resume.
6. years_of_experience: count from work history OR from explicit "X+ years" mention.

Return ONLY valid JSON in this exact schema:
{
  "name": "string or null",
  "email": "string or null",
  "phone": "string or null",
  "location": "string or null",
  "title": "string or null",
  "skills": ["skill1", "skill2"],
  "experience": [
    {
      "title": "Job Title",
      "company": "Company Name",
      "location": "City, Country",
      "start_date": "Mon YYYY",
      "end_date": "Mon YYYY or Present",
      "years": 2,
      "description": "1-3 sentence summary"
    }
  ],
  "education": [
    {
      "degree": "Degree Name",
      "field": "Field of Study",
      "institution": "Institution Name",
      "year": 2020
    }
  ],
  "certifications": ["Cert1"],
  "languages": ["English"],
  "summary": "2-4 sentence professional summary",
  "years_of_experience": 5
}

RESUME:
{$content}
PROMPT;

                $response = \OpenAI::chat()->create([
                    'model'    => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a precise resume parser. Return only valid JSON.'],
                        ['role' => 'user',   'content' => $prompt],
                    ],
                    'temperature'     => 0.1,
                    'max_tokens'      => 3000,
                    'response_format' => ['type' => 'json_object'],
                ]);

                $aiContent = $response->choices[0]->message->content;
                $data = json_decode($aiContent, true);
                if (is_array($data)) {
                    return array_merge($this->getDefaultParsedData(), $data);
                }
            }
        } catch (\Exception $e) {
            Log::warning('AI parsing failed: ' . $e->getMessage());
        }

        return $this->getDefaultParsedData();
    }

    /**
     * Default parsed data.
     */
    private function getDefaultParsedData()
    {
        return [
            'name'                => null,
            'email'               => null,
            'phone'               => null,
            'location'            => null,
            'title'               => null,
            'skills'              => [],
            'experience'          => [],
            'education'           => [],
            'certifications'      => [],
            'languages'           => [],
            'summary'             => '',
            'years_of_experience' => 0,
        ];
    }

    /**
     * Merge two arrays uniquely.
     */
    private function mergeUnique(array $a, array $b): array
    {
        return array_values(array_unique(array_merge($a, $b)));
    }

    /**
     * Extract skills from text (expanded list).
     */
    private function extractSkills($text)
    {
        $commonSkills = [
            // Languages
            'PHP', 'Python', 'JavaScript', 'TypeScript', 'Java', 'C#', 'C++', 'C', 'Ruby', 'Go', 'Rust', 'Kotlin', 'Swift', 'Dart', 'Scala', 'Perl',
            // Frontend
            'React', 'React JS', 'React Native', 'Vue', 'Vue JS', 'Angular', 'Angular JS', 'Svelte', 'Next.js', 'Nuxt', 'jQuery',
            'HTML', 'HTML5', 'CSS', 'CSS3', 'SASS', 'SCSS', 'Less', 'Bootstrap', 'Tailwind', 'Tailwind CSS', 'Material UI',
            'Inertia JS', 'Livewire', 'Alpine.js', 'Redux',
            // Backend
            'Laravel', 'Symfony', 'CodeIgniter', 'ASP.NET', 'ASP.NET Core', 'ASP .NET Core MVC', '.NET', '.NET Core',
            'Django', 'Flask', 'FastAPI', 'Express', 'NestJS', 'Spring', 'Spring Boot', 'Rails',
            'Node.js', 'NodeJS',
            // Databases
            'SQL', 'MySQL', 'PostgreSQL', 'SQL Server', 'MSSQL', 'MongoDB', 'Redis', 'SQLite', 'Oracle', 'MariaDB', 'Firebase', 'Cassandra', 'DynamoDB',
            // DevOps / Cloud
            'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP', 'Google Cloud', 'DevOps', 'CI/CD', 'Jenkins', 'GitHub Actions', 'GitLab CI',
            'Nginx', 'Apache', 'Linux', 'Ubuntu', 'Bash', 'Shell',
            // APIs / Arch
            'REST API', 'RESTful', 'GraphQL', 'WebSocket', 'gRPC', 'Microservices', 'SOA', 'MVC',
            // CMS / Ecommerce
            'WordPress', 'Shopify', 'WooCommerce', 'Magento', 'Drupal', 'Joomla',
            // Tools
            'Git', 'GitHub', 'GitLab', 'Bitbucket', 'Jira', 'Trello', 'Asana', 'Slack', 'VS Code', 'Postman', 'Figma', 'Adobe XD', 'Photoshop', 'Illustrator',
            // Data / AI
            'Machine Learning', 'Deep Learning', 'TensorFlow', 'PyTorch', 'Pandas', 'NumPy', 'Data Analysis', 'Data Science',
            // Mobile
            'Android', 'iOS', 'Flutter', 'React Native', 'Xamarin',
            // Methodologies
            'Agile', 'Scrum', 'Kanban', 'Waterfall', 'TDD', 'BDD',
            // Soft skills
            'Project Management', 'Public Relations', 'Teamwork', 'Time Management', 'Leadership',
            'Effective Communication', 'Communication', 'Critical Thinking', 'Problem Solving',
            'Team Management', 'Digital Marketing', 'SEO', 'SEM', 'Content Marketing',
            'OOP', 'Object Oriented Programming', 'OOD', 'SDLC', 'Software Development Life Cycle',
        ];

        $found = [];
        foreach ($commonSkills as $skill) {
            $pattern = '/(?<![A-Za-z0-9])' . preg_quote($skill, '/') . '(?![A-Za-z0-9])/i';
            if (preg_match($pattern, $text)) {
                $found[] = $skill;
            }
        }

        return array_values(array_unique($found));
    }

    /**
     * Match candidate to all relevant jobs.
     */
    public function matchCandidateToJobs(ResumeParse $resumeParse)
    {
        $userSkills      = $resumeParse->skills ?? [];
        $userExperience  = $resumeParse->experience ?? [];
        $userEducation   = $resumeParse->education ?? [];
        $yearsExperience = $resumeParse->parsed_data['years_of_experience'] ?? 0;

        $jobs = JobPost::where('status', 'published')->get();

        foreach ($jobs as $job) {
            try {
                $this->matchSingleJob($resumeParse, $job, [
                    'skills'           => $userSkills,
                    'experience'       => $userExperience,
                    'education'        => $userEducation,
                    'years_experience' => $yearsExperience,
                ]);
            } catch (\Exception $e) {
                Log::warning("Match failed for job {$job->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Match a single candidate to a specific job.
     */
    public function matchSingleJob($resumeParse, JobPost $job, $candidateData)
    {
        $jobRequirements = $this->extractRequirementsFromDescription($job);
        $scores          = $this->calculateMatchScores($jobRequirements, $candidateData);

        $application = Application::firstOrCreate(
            [
                'job_post_id'  => $job->id,
                'applicant_id' => $resumeParse->user_id,
            ],
            [
                'status'     => 'pending',
                'applied_at' => now(),
            ]
        );

        $match = CandidateMatch::updateOrCreate(
            [
                'job_post_id'     => $job->id,
                'application_id'  => $application->id,
                'resume_parse_id' => $resumeParse->id,
            ],
            [
                'overall_score'              => $scores['overall'],
                'skills_match_score'         => $scores['skills_match'],
                'experience_match_score'     => $scores['experience_match'],
                'education_match_score'      => $scores['education_match'],
                'certifications_match_score' => 0,
                'matched_skills'             => $scores['matched_skills'],
                'missing_skills'             => $scores['missing_skills'],
                'matching_experience'        => $scores['matching_experience'],
                'matching_education'         => $scores['matching_education'],
                'match_details'              => $scores['match_details'],
                'tier'                       => $this->getTier($scores['overall']),
                'is_recommended'             => $scores['overall'] >= 70,
                'matched_at'                 => now(),
            ]
        );

        if ($scores['overall'] >= 80) {
            $match->update(['is_shortlisted' => true]);
            $application->update(['status' => 'shortlisted']);
        }

        return $match;
    }

    /**
     * Extract requirements from job description.
     */
    private function extractRequirementsFromDescription(JobPost $job)
    {
        $text = ($job->description ?? '') . ' ' . ($job->requirements ?? '');

        $skills = $this->extractSkills($text);

        $minExperience = 0;
        if (preg_match('/(\d+)\s*\+\s*years?/i', $text, $matches)) {
            $minExperience = (int) $matches[1];
        } elseif (preg_match('/(\d+)\s*years?/i', $text, $matches)) {
            $minExperience = (int) $matches[1];
        }

        return [
            'skills'           => $skills,
            'preferred_skills' => [],
            'min_experience'   => $minExperience,
            'education'        => [],
            'certifications'   => [],
        ];
    }

    /**
     * Calculate match scores.
     */
    private function calculateMatchScores($jobRequirements, $candidateData)
    {
        $requiredSkills  = $jobRequirements['skills'] ?? [];
        $candidateSkills = $candidateData['skills'] ?? [];

        $matchedSkills = array_intersect($candidateSkills, $requiredSkills);
        $missingSkills = array_diff($requiredSkills, $candidateSkills);

        $skillsMatchScore = !empty($requiredSkills)
            ? (count($matchedSkills) / count($requiredSkills)) * 100
            : 100;

        $requiredExp  = $jobRequirements['min_experience'] ?? 0;
        $candidateExp = $candidateData['years_experience'] ?? 0;

        $experienceMatchScore = $requiredExp > 0
            ? min(($candidateExp / $requiredExp) * 100, 100)
            : 100;

        $educationMatchScore = !empty($candidateData['education']) ? 100 : 50;

        $weights = [
            'skills'     => 0.60,
            'experience' => 0.30,
            'education'  => 0.10,
        ];

        $overallScore =
            ($skillsMatchScore * $weights['skills']) +
            ($experienceMatchScore * $weights['experience']) +
            ($educationMatchScore * $weights['education']);

        return [
            'overall'             => round($overallScore, 2),
            'skills_match'        => round($skillsMatchScore, 2),
            'experience_match'    => round($experienceMatchScore, 2),
            'education_match'     => round($educationMatchScore, 2),
            'matched_skills'      => array_values($matchedSkills),
            'missing_skills'      => array_values($missingSkills),
            'matching_experience' => $candidateExp,
            'matching_education'  => $candidateData['education'] ?? [],
            'match_details'       => [
                'total_skills_required' => count($requiredSkills),
                'skills_matched'        => count($matchedSkills),
                'skills_missing'        => count($missingSkills),
                'experience_required'   => $requiredExp,
                'experience_has'        => $candidateExp,
            ],
        ];
    }

    /**
     * Get candidate tier.
     */
    private function getTier($score)
    {
        if ($score >= 90) return 'A';
        if ($score >= 75) return 'B';
        if ($score >= 60) return 'C';
        return 'D';
    }

    /**
     * Get top candidates for a job.
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
     * Get match summary for employer.
     */
    public function getMatchSummary($employerId)
    {
        $jobs = JobPost::where('employer_id', $employerId)->pluck('id');

        return [
            'total_matches'      => CandidateMatch::whereIn('job_post_id', $jobs)->count(),
            'highly_recommended' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'A')->count(),
            'shortlisted'        => CandidateMatch::whereIn('job_post_id', $jobs)->where('is_shortlisted', true)->count(),
            'average_score'      => CandidateMatch::whereIn('job_post_id', $jobs)->avg('overall_score'),
            'top_tiers'          => [
                'A' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'A')->count(),
                'B' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'B')->count(),
                'C' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'C')->count(),
                'D' => CandidateMatch::whereIn('job_post_id', $jobs)->where('tier', 'D')->count(),
            ],
        ];
    }
}
