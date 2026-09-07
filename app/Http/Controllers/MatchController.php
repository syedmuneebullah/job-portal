<?php

namespace App\Http\Controllers;

use App\Models\CandidateMatch;
use App\Models\JobPost;
use App\Models\Employer;
use App\Services\ResumeScreeningService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MatchController extends Controller
{
    protected $screeningService;

    public function __construct(ResumeScreeningService $screeningService)
    {
        $this->screeningService = $screeningService;
    }

    /**
     * Dashboard with match statistics
     */
    public function dashboard()
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');
        
        $stats = [
            'total_matches' => CandidateMatch::whereIn('job_post_id', $jobIds)->count(),
            'new_matches' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->where('is_viewed', false)
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
            'shortlisted' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->where('is_shortlisted', true)
                ->count(),
            'recommended' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->where('is_recommended', true)
                ->count(),
            'top_tiers' => [
                'A' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'A')->count(),
                'B' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'B')->count(),
                'C' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'C')->count(),
                'D' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'D')->count(),
            ],
            'average_score' => CandidateMatch::whereIn('job_post_id', $jobIds)->avg('overall_score'),
            'recent_matches' => CandidateMatch::with(['application.applicant', 'jobPost'])
                ->whereIn('job_post_id', $jobIds)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];
        
        return view('employer.pages.matches.dashboard', compact('stats'));
    }

    /**
     * Display all matches
     */
    public function allMatches(Request $request)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');
        
        $query = CandidateMatch::with(['application.applicant', 'jobPost', 'aiRecommendation'])
            ->whereIn('job_post_id', $jobIds);
        
        if ($request->filled('job_id')) {
            $query->where('job_post_id', $request->job_id);
        }
        
        if ($request->filled('tier')) {
            $query->where('tier', $request->tier);
        }
        
        if ($request->filled('shortlisted')) {
            $query->where('is_shortlisted', $request->shortlisted === 'true');
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('application.applicant', function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        $matches = $query->orderBy('overall_score', 'desc')
            ->paginate($request->per_page ?? 20);
        
        $jobs = JobPost::where('employer_id', $employer->id)
            ->select('id', 'title')
            ->get();
        
        return view('employer.pages.matches.all', compact('matches', 'jobs'));
    }

    /**
     * Display matches for a specific job
     */
    public function jobMatches($jobId, Request $request)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $job = JobPost::where('employer_id', $employer->id)->findOrFail($jobId);
        
        $query = CandidateMatch::with(['application.applicant', 'aiRecommendation'])
            ->where('job_post_id', $jobId);
        
        if ($request->filled('tier')) {
            $query->where('tier', $request->tier);
        }
        
        if ($request->filled('shortlisted')) {
            $query->where('is_shortlisted', $request->shortlisted === 'true');
        }
        
        $matches = $query->orderBy('overall_score', 'desc')
            ->paginate($request->per_page ?? 20);
        
        $summary = $this->screeningService->getMatchSummary($employer->id);
        
        return view('employer.pages.matches.index', compact('job', 'matches', 'summary'));
    }

    /**
     * Show a single match
     */
    public function show($matchId)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $match = CandidateMatch::with([
            'application.applicant',
            'application.jobPost',
            'resumeParse',
            'aiRecommendation'
        ])->findOrFail($matchId);
        
        if ($match->jobPost->employer_id !== $employer->id) {
            abort(403, 'Unauthorized');
        }
        
        if (!$match->is_viewed) {
            $match->update(['is_viewed' => true]);
        }
        
        return view('employer.pages.matches.show', compact('match'));
    }

    /**
     * Get AI recommendations (AJAX)
     */
    public function getRecommendations($matchId)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $match = CandidateMatch::with('aiRecommendation')->findOrFail($matchId);
        
        if ($match->jobPost->employer_id !== $employer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $match->aiRecommendation
        ]);
    }

    /**
     * Shortlist a candidate (AJAX)
     */
    public function shortlist($matchId)
    {
        try {
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match = CandidateMatch::with(['application', 'jobPost'])->findOrFail($matchId);
            
            if ($match->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match->update(['is_shortlisted' => true]);
            $match->application->update(['status' => 'shortlisted']);
            
            return response()->json([
                'success' => true,
                'message' => 'Candidate shortlisted successfully!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to shortlist candidate: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to shortlist candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove from shortlist (AJAX)
     */
    public function unshortlist($matchId)
    {
        try {
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match = CandidateMatch::with(['application', 'jobPost'])->findOrFail($matchId);
            
            if ($match->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match->update(['is_shortlisted' => false]);
            $match->application->update(['status' => 'pending']);
            
            return response()->json([
                'success' => true,
                'message' => 'Candidate removed from shortlist'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to unshortlist candidate: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to unshortlist candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk shortlist candidates (AJAX)
     */
    public function bulkShortlist(Request $request)
    {
        $request->validate([
            'match_ids' => 'required|array',
            'match_ids.*' => 'exists:candidate_matches,id'
        ]);
        
        try {
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $matches = CandidateMatch::with(['application', 'jobPost'])
                ->whereIn('id', $request->match_ids)
                ->get();
            
            $count = 0;
            foreach ($matches as $match) {
                if ($match->jobPost->employer_id === $employer->id) {
                    $match->update(['is_shortlisted' => true]);
                    $match->application->update(['status' => 'shortlisted']);
                    $count++;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "{$count} candidates shortlisted successfully!"
            ]);
            
        } catch (\Exception $e) {
            Log::error('Bulk shortlist failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to shortlist candidates: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark match as viewed (AJAX)
     */
    public function markAsViewed($matchId)
    {
        try {
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match = CandidateMatch::with('jobPost')->findOrFail($matchId);
            
            if ($match->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match->update(['is_viewed' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Marked as viewed'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add notes to a match (AJAX)
     */
    public function addNotes(Request $request, $matchId)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);
        
        try {
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if (!$employer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $match = CandidateMatch::with('jobPost')->findOrFail($matchId);
            
            if ($match->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $details = $match->match_details ?? [];
            $details['employer_notes'] = $request->notes;
            $details['notes_updated_at'] = now()->toDateTimeString();
            
            $match->update(['match_details' => $details]);
            
            return response()->json([
                'success' => true,
                'message' => 'Notes added successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export matches to CSV
     */
    public function export(Request $request)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');
        
        $matches = CandidateMatch::with(['application.applicant', 'jobPost'])
            ->whereIn('job_post_id', $jobIds)
            ->orderBy('overall_score', 'desc')
            ->get();
        
        $filename = 'matches_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ];
        
        $callback = function() use ($matches) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Candidate', 'Email', 'Job Title', 'Overall Score', 'Tier',
                'Skills Match', 'Experience Match', 'Education Match',
                'Shortlisted', 'Matched At'
            ]);
            
            foreach ($matches as $match) {
                fputcsv($handle, [
                    ($match->application->applicant->first_name ?? '') . ' ' . ($match->application->applicant->last_name ?? ''),
                    $match->application->applicant->email ?? '',
                    $match->jobPost->title ?? 'N/A',
                    round($match->overall_score, 2),
                    $match->tier,
                    round($match->skills_match_score, 2),
                    round($match->experience_match_score, 2),
                    round($match->education_match_score, 2),
                    $match->is_shortlisted ? 'Yes' : 'No',
                    $match->matched_at ? $match->matched_at->format('Y-m-d H:i:s') : $match->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export a single match
     */
    public function exportMatch($matchId)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $match = CandidateMatch::with(['application.applicant', 'jobPost', 'resumeParse'])
            ->findOrFail($matchId);
        
        if ($match->jobPost->employer_id !== $employer->id) {
            abort(403, 'Unauthorized');
        }
        
        $filename = 'match_' . $matchId . '_' . date('Y-m-d') . '.json';
        
        return response()->json([
            'match' => $match,
            'candidate' => $match->application->applicant,
            'job' => $match->jobPost,
            'resume' => $match->resumeParse,
            'ai_recommendations' => $match->aiRecommendation,
        ], 200, [
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ]);
    }

    /**
     * Hiring pipeline report
     */
    public function hiringPipeline()
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');
        
        $pipeline = [
            'total_candidates' => CandidateMatch::whereIn('job_post_id', $jobIds)->count(),
            'shortlisted' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('is_shortlisted', true)->count(),
            'interview_scheduled' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->whereHas('application', function($q) {
                    $q->where('status', 'interview');
                })->count(),
            'hired' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->whereHas('application', function($q) {
                    $q->where('status', 'hired');
                })->count(),
            'rejected' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->whereHas('application', function($q) {
                    $q->where('status', 'rejected');
                })->count(),
        ];
        
        return view('employer.pages.reports.pipeline', compact('pipeline'));
    }

    /**
     * Match analytics report
     */
    public function matchAnalytics()
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            abort(404, 'Employer not found');
        }
        
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');
        
        $analytics = [
            'average_score' => CandidateMatch::whereIn('job_post_id', $jobIds)->avg('overall_score'),
            'top_skills' => $this->getTopSkills($jobIds),
            'tier_distribution' => [
                'A' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'A')->count(),
                'B' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'B')->count(),
                'C' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'C')->count(),
                'D' => CandidateMatch::whereIn('job_post_id', $jobIds)->where('tier', 'D')->count(),
            ],
            'matches_over_time' => CandidateMatch::whereIn('job_post_id', $jobIds)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(30)
                ->get(),
        ];
        
        return view('employer.pages.reports.analytics', compact('analytics'));
    }

    /**
     * Get top skills from matches
     */
    private function getTopSkills($jobIds, $limit = 10)
    {
        $matches = CandidateMatch::whereIn('job_post_id', $jobIds)
            ->whereNotNull('matched_skills')
            ->get();
        
        $skillCount = [];
        foreach ($matches as $match) {
            $skills = $match->matched_skills ?? [];
            foreach ($skills as $skill) {
                $skillCount[$skill] = ($skillCount[$skill] ?? 0) + 1;
            }
        }
        
        arsort($skillCount);
        return array_slice($skillCount, 0, $limit, true);
    }
}