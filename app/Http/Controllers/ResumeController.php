<?php

namespace App\Http\Controllers;

use App\Models\ResumeParse;
use App\Models\CandidateMatch;
use App\Models\JobPost;
use App\Services\ResumeScreeningService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    protected $screeningService;

    public function __construct(ResumeScreeningService $screeningService)
    {
        $this->screeningService = $screeningService;
    }

    /**
     * Display a listing of the user's resumes
     */
    public function index()
    {
        $resumes = ResumeParse::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('jobseeker.pages.resumes.index', compact('resumes'));
    }

    /**
     * Upload and parse resume
     */
    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx,txt|max:5120',
        ]);

        try {
            $resumeParse = $this->screeningService->parseResume(
                $request->file('resume'),
                auth()->id()
            );

            if ($resumeParse->status === 'failed') {
                return redirect()->back()
                    ->with('error', 'Failed to parse resume. Please try again with a different format.');
            }

            return redirect()->route('candidate.resume.index')
                ->with('success', 'Resume uploaded and analyzed successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload resume: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resume
     */
    public function view($id)
    {
        $resume = ResumeParse::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('jobseeker.pages.resumes.view', compact('resume'));
    }

    /**
     * Remove the specified resume
     */
    public function destroy($id)
    {
        try {
            $resume = ResumeParse::where('user_id', auth()->id())
                ->findOrFail($id);
                
            // Delete file
            if ($resume->file_path && Storage::disk('public')->exists($resume->file_path)) {
                Storage::disk('public')->delete($resume->file_path);
            }
            
            $resume->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Resume deleted successfully.'
                ]);
            }
            
            return redirect()->route('candidate.resume.index')
                ->with('success', 'Resume deleted successfully.');
                
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete resume: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to delete resume: ' . $e->getMessage());
        }
    }

    /**
     * Get resume parse status (AJAX)
     */
    public function parseStatus($id)
    {
        $resume = ResumeParse::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return response()->json([
            'success' => true,
            'status' => $resume->status,
            'skills_count' => count($resume->skills ?? []),
            'experience_count' => count($resume->experience ?? []),
            'education_count' => count($resume->education ?? []),
            'certifications_count' => count($resume->certifications ?? []),
        ]);
    }

    /**
     * Display candidate's job matches
     */
    public function myMatches()
    {
        $matches = CandidateMatch::with(['jobPost', 'aiRecommendation'])
            ->whereHas('application', function($query) {
                $query->where('applicant_id', auth()->id());
            })
            ->orderBy('overall_score', 'desc')
            ->paginate(20);
            
        // Get match statistics
        $stats = [
            'total' => $matches->total(),
            'highly_recommended' => CandidateMatch::whereHas('application', function($query) {
                $query->where('applicant_id', auth()->id());
            })->where('overall_score', '>=', 80)->count(),
            'shortlisted' => CandidateMatch::whereHas('application', function($query) {
                $query->where('applicant_id', auth()->id());
            })->where('is_shortlisted', true)->count(),
            'average_score' => CandidateMatch::whereHas('application', function($query) {
                $query->where('applicant_id', auth()->id());
            })->avg('overall_score'),
        ];
            
        return view('jobseeker.pages.matches.index', compact('matches', 'stats'));
    }

    /**
     * Display match details for a specific match
     */
    public function matchDetails($id)
    {
        $match = CandidateMatch::with(['jobPost', 'application', 'aiRecommendation', 'resumeParse'])
            ->whereHas('application', function($query) {
                $query->where('applicant_id', auth()->id());
            })
            ->findOrFail($id);
            
        return view('jobseeker.pages.matches.details', compact('match'));
    }

    /**
     * Get match for a specific job (AJAX)
     */
    public function jobMatch($jobId)
    {
        $match = CandidateMatch::with(['jobPost', 'aiRecommendation'])
            ->whereHas('application', function($query) use ($jobId) {
                $query->where('applicant_id', auth()->id())
                      ->where('job_post_id', $jobId);
            })
            ->first();
            
        if (!$match) {
            return response()->json([
                'success' => false,
                'message' => 'No match found for this job',
            ], 404);
        }
            
        return response()->json([
            'success' => true,
            'data' => $match,
        ]);
    }

    /**
     * View match results for a specific job (Employer view)
     */
    public function matchResults($jobId)
    {
        $employer = auth()->user()->employer;
        $job = JobPost::where('employer_id', $employer->id)->findOrFail($jobId);
        
        $matches = $this->screeningService->getTopCandidates($jobId);
        $summary = $this->screeningService->getMatchSummary($employer->id);
        
        return view('employer.pages.jobs.matches', compact('job', 'matches', 'summary'));
    }

    /**
     * Get AI recommendations for a candidate (AJAX)
     */
    public function getRecommendations($matchId)
    {
        $match = CandidateMatch::with(['aiRecommendation', 'application', 'resumeParse'])
            ->findOrFail($matchId);
            
        return response()->json([
            'success' => true,
            'data' => $match->aiRecommendation,
        ]);
    }

    /**
     * Shortlist a candidate (AJAX)
     */
    public function shortlist($matchId)
    {
        $match = CandidateMatch::findOrFail($matchId);
        $employer = auth()->user()->employer;
        
        if ($match->jobPost->employer_id !== $employer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $match->update([
            'is_shortlisted' => true,
        ]);
        
        $match->application->update([
            'status' => 'shortlisted',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Candidate shortlisted successfully!',
        ]);
    }

    /**
     * Unshortlist a candidate (AJAX)
     */
    public function unshortlist($matchId)
    {
        $match = CandidateMatch::findOrFail($matchId);
        $employer = auth()->user()->employer;
        
        if ($match->jobPost->employer_id !== $employer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $match->update([
            'is_shortlisted' => false,
        ]);
        
        $match->application->update([
            'status' => 'pending',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Candidate removed from shortlist',
        ]);
    }
}