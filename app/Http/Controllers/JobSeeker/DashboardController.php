<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates',
        ])->find(Auth::id());

        $userId = $user->id;

        // ============================================================
        // JOB STATISTICS  (fixed status names to match Application model)
        // ============================================================
        $jobStats = [
            'total_applications'         => Application::where('applicant_id', $userId)->count(),
            'applied'                    => Application::where('applicant_id', $userId)->where('status', Application::STATUS_APPLIED)->count(),
            'under_review'               => Application::where('applicant_id', $userId)->where('status', Application::STATUS_UNDER_REVIEW)->count(),
            'shortlisted'                => Application::where('applicant_id', $userId)->where('status', Application::STATUS_SHORTLISTED)->count(),
            'interview'                  => Application::where('applicant_id', $userId)->where('status', Application::STATUS_INTERVIEW)->count(),
            'offer'                      => Application::where('applicant_id', $userId)->where('status', Application::STATUS_OFFER)->count(),
            'hired'                      => Application::where('applicant_id', $userId)->where('status', Application::STATUS_HIRED)->count(),
            'rejected'                   => Application::where('applicant_id', $userId)->where('status', Application::STATUS_REJECTED)->count(),
            'withdrawn'                  => Application::where('applicant_id', $userId)->where('status', Application::STATUS_WITHDRAWN)->count(),
        ];

        // ============================================================
        // RECENT APPLICATIONS
        // ============================================================
        $recentApplications = Application::with([
                'jobPost' => function ($q) {
                    $q->select('id', 'title', 'location', 'employer_id');
                },
                'jobPost.employer' => function ($q) {
                    $q->select('id', 'company_name', 'company_logo');
                },
            ])
            ->where('applicant_id', $userId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ============================================================
        // RECOMMENDED JOBS
        // ============================================================
        $skills = [];
        if ($user->applicantProfile && $user->applicantProfile->skills) {
            $skills = is_array($user->applicantProfile->skills)
                ? $user->applicantProfile->skills
                : json_decode($user->applicantProfile->skills, true) ?? [];
        }

        $recommendedJobs = JobPost::with([
                'employer' => function ($q) {
                    $q->select('id', 'company_name', 'company_logo');
                }
            ])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->whereDoesntHave('applications', function ($q) use ($userId) {
                $q->where('applicant_id', $userId);
            })
            ->when(!empty($skills), function ($query) use ($skills) {
                return $query->where(function ($q) use ($skills) {
                    foreach ($skills as $skill) {
                        $q->orWhere('title', 'LIKE', "%{$skill}%")
                          ->orWhere('description', 'LIKE', "%{$skill}%")
                          ->orWhere('required_skills', 'LIKE', "%{$skill}%");
                    }
                });
            })
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // ============================================================
        // PROFILE COMPLETENESS
        // ============================================================
        $profileItems = [
            'profile_photo'     => (bool) $user->profile_photo,
            'phone'             => (bool) $user->phone,
            'applicant_profile' => (bool) $user->applicantProfile,
            'summary'           => $user->applicantProfile && !empty($user->applicantProfile->summary),
            'skills'            => $user->applicantProfile && !empty($user->applicantProfile->skills),
            'education'         => $user->educations->count() > 0,
            'experience'        => $user->experiences->count() > 0,
            'certificate'       => $user->certificates->count() > 0,
        ];

        $completedItems      = count(array_filter($profileItems));
        $totalItems          = count($profileItems);
        $completenessPercent = $totalItems > 0 ? (int) round(($completedItems / $totalItems) * 100) : 0;

        $completenessLabel = 'Beginner';
        if ($completenessPercent >= 80)      $completenessLabel = 'All-Star';
        elseif ($completenessPercent >= 60)  $completenessLabel = 'Intermediate';
        elseif ($completenessPercent >= 30)  $completenessLabel = 'Advanced Beginner';

        // ============================================================
        // RECENT ACTIVITY
        // ============================================================
        $recentActivity = Application::where('applicant_id', $userId)
            ->with('jobPost:id,title')
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn($app) => [
                'type'       => 'application',
                'title'      => $app->jobPost->title ?? 'Job',
                'status'     => $app->status,
                'created_at' => $app->created_at,
            ]);

        // ============================================================
        // STAT CARD DATA  (aligned with real status names)
        // ============================================================
        $statusCounts = [
            ['label' => 'Total',        'count' => $jobStats['total_applications'], 'color' => 'blue',    'icon' => 'fas fa-file-alt'],
            ['label' => 'Applied',      'count' => $jobStats['applied'],            'color' => 'gray',    'icon' => 'fas fa-paper-plane'],
            ['label' => 'Under Review', 'count' => $jobStats['under_review'],       'color' => 'amber',   'icon' => 'fas fa-search'],
            ['label' => 'Shortlisted',  'count' => $jobStats['shortlisted'],        'color' => 'purple',  'icon' => 'fas fa-star'],
            ['label' => 'Interview',    'count' => $jobStats['interview'],          'color' => 'indigo',  'icon' => 'fas fa-handshake'],
            ['label' => 'Hired',        'count' => $jobStats['hired'],              'color' => 'emerald', 'icon' => 'fas fa-check-circle'],
        ];

        // ============================================================
        // EDUCATION / EXPERIENCE STATS
        // ============================================================
        $educationStats = [
            'total'     => $user->educations->count(),
            'ongoing'   => $user->educations->where('on_going', 'yes')->count(),
            'completed' => $user->educations->where('on_going', 'no')->count(),
        ];

        $experienceStats = [
            'total'     => $user->experiences->count(),
            'ongoing'   => $user->experiences->where('on_going', 'yes')->count(),
            'completed' => $user->experiences->where('on_going', 'no')->count(),
        ];

        // ============================================================
        // QUICK TIPS
        // ============================================================
        $quickTips = [];
        if (!$user->profile_photo) {
            $quickTips[] = 'Add a profile photo to make your profile more attractive to employers.';
        }
        if (!$user->phone) {
            $quickTips[] = 'Add your phone number so employers can contact you easily.';
        }
        if (!$user->applicantProfile || empty($user->applicantProfile->summary)) {
            $quickTips[] = 'Write a professional summary to showcase your skills and experience.';
        }
        if ($user->experiences->count() === 0) {
            $quickTips[] = 'Add your work experience to increase your chances of getting hired.';
        }
        if ($user->educations->count() === 0) {
            $quickTips[] = 'Add your educational background to complete your profile.';
        }
        if ($user->certificates->count() === 0) {
            $quickTips[] = 'Add your certifications to boost your credibility.';
        }

        // ============================================================
        // ✅ NEW: CHART DATA
        // ============================================================

        // ---- 1. Applications by status (doughnut) ----
        $statusChart = [
            'labels' => [],
            'data'   => [],
            'colors' => [],
        ];
        $statusMap = [
            Application::STATUS_APPLIED      => ['Applied',      '#6b7280'],
            Application::STATUS_UNDER_REVIEW => ['Under Review', '#f59e0b'],
            Application::STATUS_SHORTLISTED  => ['Shortlisted',  '#6366f1'],
            Application::STATUS_INTERVIEW    => ['Interview',    '#a855f7'],
            Application::STATUS_OFFER        => ['Offer',        '#8b5cf6'],
            Application::STATUS_HIRED        => ['Hired',        '#10b981'],
            Application::STATUS_REJECTED     => ['Rejected',     '#ef4444'],
            Application::STATUS_WITHDRAWN    => ['Withdrawn',    '#9ca3af'],
        ];

        foreach ($statusMap as $status => $meta) {
            $count = Application::where('applicant_id', $userId)->where('status', $status)->count();
            if ($count > 0) {
                $statusChart['labels'][] = $meta[0];
                $statusChart['data'][]   = $count;
                $statusChart['colors'][] = $meta[1];
            }
        }

        // ---- 2. Applications over last 30 days (line) ----
        $startDate = now()->subDays(29)->startOfDay();

        $appsByDay = Application::where('applicant_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $activityChart = ['labels' => [], 'data' => []];
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $activityChart['labels'][] = Carbon::parse($date)->format('M d');
            $activityChart['data'][]   = (int) ($appsByDay[$date] ?? 0);
        }

        // ---- 3. Profile completeness breakdown ----
        $profileChart = [
            'labels'  => [],
            'data'    => [],
            'colors'  => [],
        ];
        foreach ($profileItems as $key => $completed) {
            $profileChart['labels'][] = ucwords(str_replace('_', ' ', $key));
            $profileChart['data'][]   = $completed ? 1 : 0;
            $profileChart['colors'][] = $completed ? '#10b981' : '#e5e7eb';
        }

        return view('jobseeker.pages.dashboard', compact(
            'user',
            'jobStats',
            'recentApplications',
            'recommendedJobs',
            'profileItems',
            'completenessPercent',
            'completenessLabel',
            'recentActivity',
            'statusCounts',
            'educationStats',
            'experienceStats',
            'quickTips',
            'statusChart',
            'activityChart',
            'profileChart'
        ));
    }
}