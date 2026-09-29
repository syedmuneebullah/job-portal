<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Interview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        // ============================================================
        // TOP-LEVEL STAT CARDS
        // ============================================================
        $now        = now();
        $lastMonth  = now()->subMonth();

        $stats = [
            'total_users'          => User::count(),
            'users_this_month'     => User::where('created_at', '>=', $lastMonth)->count(),
            'users_last_month'     => User::whereBetween('created_at', [$lastMonth->copy()->subMonth(), $lastMonth])->count(),

            'total_employers'      => Employer::count(),
            'employers_this_month' => Employer::where('created_at', '>=', $lastMonth)->count(),
            'employers_last_month' => Employer::whereBetween('created_at', [$lastMonth->copy()->subMonth(), $lastMonth])->count(),

            'total_jobs'           => JobPost::count(),
            'jobs_this_month'      => JobPost::where('created_at', '>=', $lastMonth)->count(),
            'jobs_last_month'      => JobPost::whereBetween('created_at', [$lastMonth->copy()->subMonth(), $lastMonth])->count(),

            'total_applications'   => Application::count(),
            'apps_this_month'      => Application::where('created_at', '>=', $lastMonth)->count(),
            'apps_last_month'      => Application::whereBetween('created_at', [$lastMonth->copy()->subMonth(), $lastMonth])->count(),

            'active_jobs'          => JobPost::where('status', 'published')->count(),
            'draft_jobs'           => JobPost::where('status', 'draft')->count(),
            'archived_jobs'        => JobPost::where('status', 'archived')->count(),
            'trashed_jobs'         => JobPost::onlyTrashed()->count(),

            'published_jobs'       => JobPost::where('status', 'published')
                                        ->whereNull('deleted_at')
                                        ->count(),

            'hired_count'          => Application::where('status', 'hired')->count(),
            'shortlisted_count'    => Application::where('status', 'shortlisted')->count(),
            'interview_count'      => Application::where('status', 'interview')->count(),
            'rejected_count'       => Application::where('status', 'rejected')->count(),
        ];

        // Compute percentage changes
        $stats['users_growth']  = $this->percentChange($stats['users_this_month'], $stats['users_last_month']);
        $stats['jobs_growth']   = $this->percentChange($stats['jobs_this_month'], $stats['jobs_last_month']);
        $stats['apps_growth']   = $this->percentChange($stats['apps_this_month'], $stats['apps_last_month']);
        $stats['employers_growth'] = $this->percentChange($stats['employers_this_month'], $stats['employers_last_month']);

        // ============================================================
        // LINE CHART — Daily registrations + applications (last 30 days)
        // ============================================================
        $startDate = now()->subDays(29)->startOfDay();

        $usersByDay = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $appsByDay = Application::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $jobsByDay = JobPost::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $lineChart = [
            'labels'       => [],
            'users'        => [],
            'applications' => [],
            'jobs'         => [],
        ];

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $lineChart['labels'][]       = Carbon::parse($date)->format('M d');
            $lineChart['users'][]        = (int) ($usersByDay[$date] ?? 0);
            $lineChart['applications'][] = (int) ($appsByDay[$date] ?? 0);
            $lineChart['jobs'][]         = (int) ($jobsByDay[$date] ?? 0);
        }

        // ============================================================
        // DOUGHNUT CHART — Applications by status
        // ============================================================
        $appsByStatus = Application::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $doughnutChart = [
            'labels' => array_map(fn($s) => ucwords(str_replace('_', ' ', $s)), array_keys($appsByStatus)),
            'data'   => array_values($appsByStatus),
        ];

        // ============================================================
        // BAR CHART — Top 5 employers by job count
        // ============================================================
        $topEmployers = Employer::withCount('jobPosts')
            ->orderByDesc('job_posts_count')
            ->take(5)
            ->get(['id', 'company_name']);

        $barChart = [
            'labels' => $topEmployers->pluck('company_name')->toArray(),
            'data'   => $topEmployers->pluck('job_posts_count')->toArray(),
        ];

        // ============================================================
        // PIE CHART — Jobs by employment type
        // ============================================================
        $jobsByType = JobPost::selectRaw('employment_type, COUNT(*) as total')
            ->whereNotNull('employment_type')
            ->groupBy('employment_type')
            ->pluck('total', 'employment_type')
            ->toArray();

        $employmentChart = [
            'labels' => array_map(fn($s) => ucwords(str_replace('_', ' ', $s)), array_keys($jobsByType)),
            'data'   => array_values($jobsByType),
        ];

        // ============================================================
        // RECENT DATA (for tables)
        // ============================================================
        $recentUsers = User::orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'first_name', 'last_name', 'email', 'created_at', 'status']);

        $recentJobs = JobPost::with(['employer:id,company_name'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'title', 'employer_id', 'employment_type', 'status', 'created_at']);

        $recentApplications = Application::with([
                'applicant:id,first_name,last_name,email',
                'jobPost:id,title,employer_id'
            ])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // ============================================================
        // SUBSCRIPTION REVENUE (last 6 months)
        // ============================================================
        $revenueByMonth = UserSubscription::where('user_subscriptions.created_at', '>=', now()->subMonths(6))
    ->whereIn('user_subscriptions.status', ['active', 'expired'])
    ->join('subscription_plans', 'user_subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
    ->selectRaw('DATE_FORMAT(user_subscriptions.created_at, "%Y-%m") as month, SUM(subscription_plans.price) as revenue')
    ->groupBy('month')
    ->pluck('revenue', 'month');

        $revenueChart = ['labels' => [], 'data' => []];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $revenueChart['labels'][] = Carbon::parse($month . '-01')->format('M Y');
            $revenueChart['data'][]   = (float) ($revenueByMonth[$month] ?? 0);
        }

        // ============================================================
        // TOP STATS FOR OPTIONAL STATS
        // ============================================================
       $totalRevenue = UserSubscription::whereIn('user_subscriptions.status', ['active', 'expired'])
    ->join('subscription_plans', 'user_subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
    ->sum('subscription_plans.price');

        $activeSubscriptions = UserSubscription::where('status', 'active')->count();

        return view('admin.pages.dashboard', compact(
            'stats',
            'lineChart',
            'doughnutChart',
            'barChart',
            'employmentChart',
            'revenueChart',
            'recentUsers',
            'recentJobs',
            'recentApplications',
            'totalRevenue',
            'activeSubscriptions'
        ));
    }

    /**
     * Calculate % change between two numbers.
     */
    private function percentChange($current, $previous): float
    {
        if ($previous <= 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }
}