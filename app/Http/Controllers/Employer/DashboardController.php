<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\Interview;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();

        if (!$employer) {
            return view('employer.pages.dashboard-no-profile');
        }

        $employerId = $employer->id;

        // ============================================================
        // EMPLOYER-SCOPED QUERIES
        // ============================================================
        $jobIds = JobPost::where('employer_id', $employerId)->pluck('id');

        $appsQuery = Application::whereIn('job_post_id', $jobIds);

        // ============================================================
        // TOP STATS
        // ============================================================
        $now       = now();
        $lastMonth = now()->subMonth();

        $stats = [
            'total_jobs'         => $jobIds->count(),
            'active_jobs'        => JobPost::where('employer_id', $employerId)
                                        ->where('status', 'published')
                                        ->whereNull('deleted_at')
                                        ->count(),
            'draft_jobs'         => JobPost::where('employer_id', $employerId)
                                        ->where('status', 'draft')
                                        ->whereNull('deleted_at')
                                        ->count(),
            'archived_jobs'      => JobPost::where('employer_id', $employerId)
                                        ->where('status', 'archived')
                                        ->whereNull('deleted_at')
                                        ->count(),

            'total_applications' => $appsQuery->count(),
            'apps_this_month'    => (clone $appsQuery)->where('created_at', '>=', $lastMonth)->count(),
            'apps_last_month'    => (clone $appsQuery)
                                        ->whereBetween('created_at', [
                                            $lastMonth->copy()->subMonth(),
                                            $lastMonth
                                        ])->count(),

            'jobs_this_month'    => JobPost::where('employer_id', $employerId)
                                        ->where('created_at', '>=', $lastMonth)
                                        ->count(),

            'hired_count'        => (clone $appsQuery)->where('status', 'hired')->count(),
            'shortlisted_count'  => (clone $appsQuery)->where('status', 'shortlisted')->count(),
            'interview_count'    => (clone $appsQuery)->where('status', 'interview')->count(),
            'rejected_count'     => (clone $appsQuery)->where('status', 'rejected')->count(),
            'under_review_count' => (clone $appsQuery)->where('status', 'under_review')->count(),
            'pending_count'      => (clone $appsQuery)->where('status', 'applied')->count(),

            // Screening insights
            'total_strong_matches' => (clone $appsQuery)
                ->where('auto_knocked_out', false)
                ->whereIn('screening_band', ['strong', 'good'])
                ->count(),
            'total_knocked_out' => (clone $appsQuery)
                ->where('auto_knocked_out', true)
                ->count(),
            'unscreened_jobs' => JobPost::where('employer_id', $employerId)
                ->whereNull('deleted_at')
                ->whereHas('applications')
                ->whereDoesntHave('applications', function ($q) {
                    $q->whereNotNull('screened_at');
                })
                ->count(),
        ];

        // Growth percentages
        $stats['apps_growth'] = $this->percentChange(
            $stats['apps_this_month'],
            $stats['apps_last_month']
        );

        // ============================================================
        // LINE CHART — Applications received last 30 days
        // ============================================================
        $startDate = now()->subDays(29)->startOfDay();

        $appsByDay = Application::whereIn('job_post_id', $jobIds)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $viewsByDay = JobPost::where('employer_id', $employerId)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $lineChart = ['labels' => [], 'applications' => [], 'jobs' => []];

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $lineChart['labels'][]       = Carbon::parse($date)->format('M d');
            $lineChart['applications'][] = (int) ($appsByDay[$date] ?? 0);
            $lineChart['jobs'][]         = (int) ($viewsByDay[$date] ?? 0);
        }

        // ============================================================
        // DOUGHNUT — Applications by status
        // ============================================================
        $appsByStatus = Application::whereIn('job_post_id', $jobIds)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $doughnutChart = [
            'labels' => array_map(fn($s) => ucwords(str_replace('_', ' ', $s)), array_keys($appsByStatus)),
            'data'   => array_values($appsByStatus),
        ];

        // ============================================================
        // BAR — Top performing jobs (by application count)
        // ============================================================
        $topJobs = JobPost::where('employer_id', $employerId)
            ->whereNull('deleted_at')
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get(['id', 'title']);

        $barChart = [
            'labels' => $topJobs->pluck('title')
                ->map(fn($t) => \Str::limit($t, 20))
                ->toArray(),
            'data'   => $topJobs->pluck('applications_count')->toArray(),
        ];

        // ============================================================
        // PIE — Screening band distribution
        // ============================================================
        $screeningDist = Application::whereIn('job_post_id', $jobIds)
            ->whereNotNull('screened_at')
            ->selectRaw('screening_band, COUNT(*) as total')
            ->groupBy('screening_band')
            ->pluck('total', 'screening_band')
            ->toArray();

        $screeningChart = [
            'labels' => array_map(fn($s) => ucfirst($s ?? 'Not set'), array_keys($screeningDist)),
            'data'   => array_values($screeningDist),
        ];

        // ============================================================
        // RECENT DATA
        // ============================================================
        $recentApplications = Application::with([
                'applicant:id,first_name,last_name,email',
                'jobPost:id,title',
            ])
            ->whereIn('job_post_id', $jobIds)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $recentJobs = JobPost::where('employer_id', $employerId)
            ->whereNull('deleted_at')
            ->withCount('applications')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Upcoming interviews
        $upcomingInterviews = Interview::whereHas('application', function ($q) use ($jobIds) {
                $q->whereIn('job_post_id', $jobIds);
            })
            ->where('scheduled_at', '>=', now())
            ->where('status', 'scheduled')
            ->with(['application.applicant:id,first_name,last_name,email', 'application.jobPost:id,title'])
            ->orderBy('scheduled_at')
            ->take(4)
            ->get();

        // ============================================================
        // STRONG CANDIDATES TO REVIEW (top screened)
        // ============================================================
        $topCandidates = Application::with([
                'applicant:id,first_name,last_name,email',
                'jobPost:id,title',
            ])
            ->whereIn('job_post_id', $jobIds)
            ->whereNotNull('screened_at')
            ->where('auto_knocked_out', false)
            ->orderByDesc('screening_score')
            ->take(5)
            ->get();

        return view('employer.pages.dashboard', compact(
            'employer',
            'stats',
            'lineChart',
            'doughnutChart',
            'barChart',
            'screeningChart',
            'recentApplications',
            'recentJobs',
            'upcomingInterviews',
            'topCandidates'
        ));
    }

    /**
     * % change between two numbers.
     */
    private function percentChange($current, $previous): float
    {
        if ($previous <= 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }
}