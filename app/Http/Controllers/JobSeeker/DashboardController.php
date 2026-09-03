<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\ApplicantEducation;
use App\Models\ApplicantExperience;
use App\Models\ApplicantCertificate;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $user = User::with([
            'applicantProfile',
            'educations',
            'experiences',
            'certificates',
            'applications' => function($query) {
                $query->latest()->limit(5);
            },
            'applications.jobPost' => function($query) {
                $query->select('id', 'title', 'location');
            }
        ])->find(Auth::id());

        // ===== JOB STATISTICS =====
        $jobStats = [
            'total_applications' => Application::where('applicant_id', $user->id)->count(),
            'pending_applications' => Application::where('applicant_id', $user->id)->where('status', 'pending')->count(),
            'shortlisted_applications' => Application::where('applicant_id', $user->id)->where('status', 'shortlisted')->count(),
            'interviewing_applications' => Application::where('applicant_id', $user->id)->where('status', 'interviewing')->count(),
            'hired_applications' => Application::where('applicant_id', $user->id)->where('status', 'hired')->count(),
            'rejected_applications' => Application::where('applicant_id', $user->id)->where('status', 'rejected')->count(),
        ];

        // ===== RECENT APPLICATIONS =====
        $recentApplications = Application::with(['jobPost' => function($query) {
                $query->select('id', 'title', 'location');
            }])
            ->where('applicant_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ===== RECOMMENDED JOBS =====
        // Get jobs based on user's skills and preferences
        $skills = [];
        if ($user->applicantProfile && $user->applicantProfile->skills) {
            $skills = is_array($user->applicantProfile->skills) 
                ? $user->applicantProfile->skills 
                : json_decode($user->applicantProfile->skills, true) ?? [];
        }

        $recommendedJobs = JobPost::with(['employer' => function($query) {
                $query->select('id', 'company_name', 'company_logo');
            }])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->whereDoesntHave('applications', function($query) use ($user) {
                $query->where('applicant_id', $user->id);
            })
            ->when(!empty($skills), function($query) use ($skills) {
                // Search for jobs matching user's skills
                return $query->where(function($q) use ($skills) {
                    foreach ($skills as $skill) {
                        $q->orWhere('title', 'LIKE', "%{$skill}%")
                          ->orWhere('description', 'LIKE', "%{$skill}%")
                          ->orWhere('required_skills', 'LIKE', "%{$skill}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ===== PROFILE COMPLETENESS =====
        $profileItems = [
            'profile_photo' => (bool) $user->profile_photo,
            'phone' => (bool) $user->phone,
            'applicant_profile' => (bool) $user->applicantProfile,
            'summary' => $user->applicantProfile && !empty($user->applicantProfile->summary),
            'skills' => $user->applicantProfile && !empty($user->applicantProfile->skills),
            'education' => $user->educations->count() > 0,
            'experience' => $user->experiences->count() > 0,
            'certificate' => $user->certificates->count() > 0,
        ];

        $completedItems = count(array_filter($profileItems));
        $totalItems = count($profileItems);
        $completenessPercent = $totalItems > 0 ? (int) round(($completedItems / $totalItems) * 100) : 0;
        
        $completenessLabel = 'Beginner';
        if ($completenessPercent >= 80) {
            $completenessLabel = 'All-Star';
        } elseif ($completenessPercent >= 60) {
            $completenessLabel = 'Intermediate';
        } elseif ($completenessPercent >= 30) {
            $completenessLabel = 'Advanced Beginner';
        }

        // ===== RECENT ACTIVITY =====
        $recentActivity = collect();
        
        // Get recent applications
        $applications = Application::where('applicant_id', $user->id)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($app) {
                return [
                    'type' => 'application',
                    'title' => $app->jobPost->title ?? 'Job',
                    'status' => $app->status,
                    'created_at' => $app->created_at,
                ];
            });
        
        $recentActivity = $recentActivity->merge($applications);
        $recentActivity = $recentActivity->sortByDesc('created_at')->take(10);

        // ===== APPLICATION STATUS COUNTS FOR CARDS =====
        $statusCounts = [
            ['label' => 'Total Applications', 'count' => $jobStats['total_applications'], 'color' => 'blue', 'icon' => 'fas fa-file-alt'],
            ['label' => 'Pending', 'count' => $jobStats['pending_applications'], 'color' => 'amber', 'icon' => 'fas fa-clock'],
            ['label' => 'Shortlisted', 'count' => $jobStats['shortlisted_applications'], 'color' => 'purple', 'icon' => 'fas fa-star'],
            ['label' => 'Interviewing', 'count' => $jobStats['interviewing_applications'], 'color' => 'blue', 'icon' => 'fas fa-handshake'],
            ['label' => 'Hired', 'count' => $jobStats['hired_applications'], 'color' => 'emerald', 'icon' => 'fas fa-check-circle'],
            ['label' => 'Rejected', 'count' => $jobStats['rejected_applications'], 'color' => 'red', 'icon' => 'fas fa-times-circle'],
        ];

        // ===== EDUCATION STATS =====
        $educationStats = [
            'total' => $user->educations->count(),
            'ongoing' => $user->educations->where('on_going', 'yes')->count(),
            'completed' => $user->educations->where('on_going', 'no')->count(),
        ];

        // ===== EXPERIENCE STATS =====
        $experienceStats = [
            'total' => $user->experiences->count(),
            'ongoing' => $user->experiences->where('on_going', 'yes')->count(),
            'completed' => $user->experiences->where('on_going', 'no')->count(),
        ];

        // ===== QUICK TIPS =====
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
            'quickTips'
        ));
    }
}