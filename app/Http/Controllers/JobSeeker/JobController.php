<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\SavedJob;
use App\Models\Application;
use App\Models\ApplicantProfile;

class JobController extends Controller
{
    public function JobPosts(Request $request)
    {
        // Start query for published jobs
        $query = JobPost::with(['employer' => function($query) {
            $query->select('id', 'company_name', 'company_logo', 'industry');
        }])
        ->where('status', 'published')
        ->whereNull('deleted_at');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhereHas('employer', function($e) use ($search) {
                      $e->where('company_name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Order by
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $jobs = $query->paginate(10);

        // Get the selected job (if any)
        $selectedJobId = $request->job_id;
        $selectedJob = null;
        
        if ($selectedJobId) {
            $selectedJob = JobPost::with(['employer', 'questions'])
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->find($selectedJobId);
        } elseif ($jobs->isNotEmpty()) {
            // Auto-select the first job if no job is selected
            $selectedJob = $jobs->first();
        }

        // Get saved job IDs for the current user
        $savedJobIds = [];
        if (auth()->check()) {
            $savedJobIds = SavedJob::where('user_id', auth()->id())
                ->saved()
                ->pluck('job_post_id')
                ->toArray();
        }

        // Get filter options
        $workTypes = JobPost::where('status', 'published')
            ->distinct()
            ->pluck('work_type');
            
        $employmentTypes = JobPost::where('status', 'published')
            ->distinct()
            ->pluck('employment_type');

        return view('jobseeker.pages.job-listings', compact(
            'jobs', 
            'selectedJob', 
            'workTypes', 
            'employmentTypes',
            'savedJobIds'
        ));
    }

    public function getJobDetails($id)
{
    $job = JobPost::with(['employer', 'questions'])
        ->where('status', 'published')
        ->whereNull('deleted_at')
        ->findOrFail($id);

    // Check if job is saved by current user
    $isSaved = false;
    $savedJob = null;
    if (auth()->check()) {
        $savedJob = SavedJob::where('user_id', auth()->id())
            ->where('job_post_id', $id)
            ->first();
        $isSaved = (bool) $savedJob;
    }

    // Check if user has already applied
    $hasApplied = false;
    $application = null;
    if (auth()->check()) {
        $application = Application::where('applicant_id', auth()->id())
            ->where('job_post_id', $id)
            ->first();
        $hasApplied = (bool) $application;
    }

    // Get similar jobs
    $similarJobs = JobPost::with(['employer' => function($q) {
        $q->select('id', 'company_name', 'company_logo');
    }])
    ->where('status', 'published')
    ->whereNull('deleted_at')
    ->where('id', '!=', $id)
    ->where(function($query) use ($job) {
        $query->where('location', $job->location)
              ->orWhere('work_type', $job->work_type)
              ->orWhere('employment_type', $job->employment_type);
    })
    ->limit(4)
    ->get();

    // Get saved job IDs for the current user
    $savedJobIds = [];
    if (auth()->check()) {
        $savedJobIds = SavedJob::where('user_id', auth()->id())
            ->saved()
            ->pluck('job_post_id')
            ->toArray();
    }

    return view('jobseeker.pages.job-details', compact('job', 'isSaved', 'savedJob', 'hasApplied', 'application', 'similarJobs', 'savedJobIds'));
}

    // ===== APPLY JOB METHODS =====

    /**
     * Show the application form for a job
     */
    public function showApplyForm($id)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.user.login')
                ->with('error', 'Please login to apply for this job.');
        }

        $job = JobPost::with(['employer', 'questions'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        // Check if already applied
        $existingApplication = Application::where('applicant_id', auth()->id())
            ->where('job_post_id', $id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()
                ->with('error', 'You have already applied for this job.');
        }

        $user = auth()->user();
        $applicantProfile = ApplicantProfile::where('user_id', auth()->id())->first();

        return view('jobseeker.pages.apply-job', compact('job', 'user', 'applicantProfile'));
    }

    /**
     * Submit the job application
     */
    public function applyJob(Request $request)
    {
        // Validate the request
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'cover_letter' => 'nullable|string|max:5000',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:1000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'terms' => 'required|accepted',
        ]);

        $jobPostId = $request->job_post_id;
        $applicantId = auth()->id();

        // Check if already applied
        $existingApplication = Application::where('applicant_id', $applicantId)
            ->where('job_post_id', $jobPostId)
            ->first();

        if ($existingApplication) {
            return redirect()->back()
                ->with('error', 'You have already applied for this job.');
        }

        // Check if job exists and is published
        $job = JobPost::where('id', $jobPostId)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->first();

        if (!$job) {
            return redirect()->back()
                ->with('error', 'This job is no longer available.');
        }

        // Handle resume upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        } else {
            // Use existing resume from profile if available
            $applicantProfile = ApplicantProfile::where('user_id', $applicantId)->first();
            if ($applicantProfile && $applicantProfile->resume_path) {
                $resumePath = $applicantProfile->resume_path;
            }
        }

        // Create application
        $application = Application::create([
            'job_post_id' => $jobPostId,
            'applicant_id' => $applicantId,
            'status' => Application::STATUS_APPLIED,
            'cover_letter' => $request->cover_letter,
            'answers' => $request->answers,
            'resume_path' => $resumePath,
            'applied_at' => now(),
        ]);

        // Update saved job status if exists
        $savedJob = SavedJob::where('user_id', $applicantId)
            ->where('job_post_id', $jobPostId)
            ->first();

        if ($savedJob) {
            $savedJob->update([
                'status' => 'applied',
                'applied_at' => now(),
            ]);
        }

        // Flash success message and redirect
        return redirect()->route('candidate.jobs.listings')
            ->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * Quick apply for a job (without showing form)
     */
    public function quickApply(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to apply for this job.'
            ], 401);
        }

        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
        ]);

        $jobPostId = $request->job_post_id;
        $applicantId = auth()->id();

        // Check if already applied
        $existingApplication = Application::where('applicant_id', $applicantId)
            ->where('job_post_id', $jobPostId)
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this job.'
            ], 422);
        }

        // Check if user has a resume
        $applicantProfile = ApplicantProfile::where('user_id', $applicantId)->first();
        if (!$applicantProfile || !$applicantProfile->resume_path) {
            return response()->json([
                'success' => false,
                'message' => 'Please upload a resume in your profile before applying.'
            ], 422);
        }

        // Create application
        $application = Application::create([
            'job_post_id' => $jobPostId,
            'applicant_id' => $applicantId,
            'status' => Application::STATUS_APPLIED,
            'resume_path' => $applicantProfile->resume_path,
            'applied_at' => now(),
        ]);

        // Update saved job status if exists
        $savedJob = SavedJob::where('user_id', $applicantId)
            ->where('job_post_id', $jobPostId)
            ->first();

        if ($savedJob) {
            $savedJob->update([
                'status' => 'applied',
                'applied_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'data' => $application
        ]);
    }

    /**
     * Get application status for a job
     */
    public function getApplicationStatus($jobPostId)
    {
        if (!auth()->check()) {
            return response()->json([
                'has_applied' => false,
                'application' => null
            ]);
        }

        $application = Application::where('applicant_id', auth()->id())
            ->where('job_post_id', $jobPostId)
            ->first();

        return response()->json([
            'has_applied' => (bool) $application,
            'application' => $application,
            'status' => $application ? $application->status : null,
            'status_label' => $application ? $application->status_label : null,
        ]);
    }

    /**
     * Get all applications for the current user
     */
    public function getMyApplications(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.user.login');
        }

        $applications = Application::with(['jobPost' => function($query) {
                $query->with(['employer' => function($q) {
                    $q->select('id', 'company_name', 'company_logo', 'industry');
                }]);
            }])
            ->where('applicant_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get statistics
        $stats = [
            'total' => Application::where('applicant_id', auth()->id())->count(),
            'applied' => Application::where('applicant_id', auth()->id())->where('status', 'applied')->count(),
            'under_review' => Application::where('applicant_id', auth()->id())->where('status', 'under_review')->count(),
            'shortlisted' => Application::where('applicant_id', auth()->id())->where('status', 'shortlisted')->count(),
            'interview' => Application::where('applicant_id', auth()->id())->where('status', 'interview')->count(),
            'offer' => Application::where('applicant_id', auth()->id())->where('status', 'offer')->count(),
            'hired' => Application::where('applicant_id', auth()->id())->where('status', 'hired')->count(),
            'rejected' => Application::where('applicant_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        return view('jobseeker.pages.my-applications', compact('applications', 'stats'));
    }

    /**
     * Withdraw an application
     */
    public function withdrawApplication($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to withdraw application.'
            ], 401);
        }

        $application = Application::where('applicant_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found.'
            ], 404);
        }

        if ($application->status === 'hired' || $application->status === 'rejected') {
            return response()->json([
                'success' => false,
                'message' => 'You cannot withdraw this application.'
            ], 422);
        }

        $application->update([
            'status' => 'withdrawn',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application withdrawn successfully.'
        ]);
    }

    // ===== SAVED JOBS METHODS =====
    
    /**
     * Save a job
     */
    public function saveJob(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save jobs.',
            ], 401);
        }

        // Check if already saved
        $existing = SavedJob::where('user_id', auth()->id())
            ->where('job_post_id', $request->job_post_id)
            ->first();

        if ($existing) {
            // If archived, restore it
            if ($existing->status === 'archived') {
                $existing->update([
                    'status' => 'saved', 
                    'notes' => $request->notes ?? $existing->notes
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Job restored to saved list.',
                    'action' => 'restored',
                    'is_saved' => true,
                    'data' => $existing
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Job already saved.',
                'action' => 'already_saved',
                'is_saved' => true,
                'data' => $existing
            ], 422);
        }

        $savedJob = SavedJob::create([
            'user_id' => auth()->id(),
            'job_post_id' => $request->job_post_id,
            'notes' => $request->notes,
            'status' => 'saved',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job saved successfully.',
            'action' => 'saved',
            'is_saved' => true,
            'data' => $savedJob
        ]);
    }

    /**
     * Unsave a job (remove from saved list)
     */
    public function unsaveJob($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to manage saved jobs.',
            ], 401);
        }

        $savedJob = SavedJob::where('user_id', auth()->id())
            ->where('job_post_id', $id)
            ->first();

        if (!$savedJob) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found in saved list.',
            ], 404);
        }

        $savedJob->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job removed from saved list.',
            'action' => 'unsaved',
            'is_saved' => false
        ]);
    }

    /**
     * Toggle save status (save/unsave)
     */
    public function toggleSave(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save jobs.',
            ], 401);
        }

        $savedJob = SavedJob::where('user_id', auth()->id())
            ->where('job_post_id', $request->job_post_id)
            ->first();

        if ($savedJob) {
            // If saved, remove it
            $savedJob->delete();
            return response()->json([
                'success' => true,
                'message' => 'Job unsaved successfully.',
                'action' => 'unsaved',
                'is_saved' => false
            ]);
        } else {
            // If not saved, save it
            $savedJob = SavedJob::create([
                'user_id' => auth()->id(),
                'job_post_id' => $request->job_post_id,
                'notes' => $request->notes,
                'status' => 'saved',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Job saved successfully.',
                'action' => 'saved',
                'is_saved' => true,
                'data' => $savedJob
            ]);
        }
    }

    /**
     * Update saved job status (e.g., mark as applied)
     */
    public function updateSavedJob(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:saved,applied,archived',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to update saved jobs.',
            ], 401);
        }

        $savedJob = SavedJob::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$savedJob) {
            return response()->json([
                'success' => false,
                'message' => 'Saved job not found.',
            ], 404);
        }

        $savedJob->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saved job updated successfully.',
            'data' => $savedJob
        ]);
    }

    /**
     * Check if a job is saved
     */
    public function checkSavedStatus($jobPostId)
    {
        if (!auth()->check()) {
            return response()->json([
                'is_saved' => false,
                'saved' => null
            ]);
        }

        $savedJob = SavedJob::where('user_id', auth()->id())
            ->where('job_post_id', $jobPostId)
            ->first();

        return response()->json([
            'is_saved' => (bool) $savedJob,
            'saved' => $savedJob,
            'status' => $savedJob ? $savedJob->status : null,
            'notes' => $savedJob ? $savedJob->notes : null,
        ]);
    }

    /**
     * Get all saved jobs for the current user
     */
    public function getSavedJobs(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.user.login');
        }

        $savedJobs = SavedJob::with(['jobPost' => function($query) {
                $query->with(['employer' => function($q) {
                    $q->select('id', 'company_name', 'company_logo', 'industry');
                }])
                ->where('status', 'published')
                ->whereNull('deleted_at');
            }])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get statistics
        $stats = [
            'total' => SavedJob::where('user_id', auth()->id())->count(),
            'saved' => SavedJob::where('user_id', auth()->id())->saved()->count(),
            'applied' => SavedJob::where('user_id', auth()->id())->applied()->count(),
            'archived' => SavedJob::where('user_id', auth()->id())->archived()->count(),
        ];

        return view('jobseeker.pages.saved-jobs', compact('savedJobs', 'stats'));
    }
}