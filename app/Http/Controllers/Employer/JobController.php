<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of job posts with search, filters, and pagination
     */
    public function index(Request $request)
{
    // Get the authenticated admin user ID
    $authUserId = auth()->id();
    
    // Find the employer associated with this user
    $employer = Employer::where('user_id', $authUserId)->first();
    
    // Get the employer ID if found, otherwise null
    $employerId = $employer ? $employer->id : null;
    
    // Base query with eager loading
    $query = JobPost::query()
        ->with(['employer' => function($q) {
            $q->select('id', 'company_name', 'email');
        }, 'recruiter' => function($q) {
            $q->select('id', 'first_name', 'last_name', 'email');
        }])
        ->select([
            'id',
            'title',
            'department',
            'location',
            'work_type',
            'employment_type',
            'salary_min',
            'salary_max',
            'currency',
            'employer_id',
            'recruiter_id',
            'visibility',
            'status',
            'is_ai_generated',
            'published_at',
            'closing_at',
            'created_at',
            'updated_at'
        ]);

    // Filter jobs based on employer ID found from user_id
    if ($employerId) {
        $query->where('employer_id', $employerId);
    } else {
        // If user is not associated with any employer, return empty results
        $query->whereRaw('1 = 0'); // Returns no results
    }

    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('department', 'LIKE', "%{$search}%")
              ->orWhere('location', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhereHas('employer', function($e) use ($search) {
                  $e->where('company_name', 'LIKE', "%{$search}%");
              });
        });
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by work type
    if ($request->filled('work_type')) {
        $query->where('work_type', $request->work_type);
    }

    // Filter by employment type
    if ($request->filled('employment_type')) {
        $query->where('employment_type', $request->employment_type);
    }

    // Filter by visibility
    if ($request->filled('visibility')) {
        $query->where('visibility', $request->visibility);
    }

    // Filter by employer
    if ($request->filled('employer_id')) {
        $query->where('employer_id', $request->employer_id);
    }

    // Filter by date range
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }

    // Filter by AI generated
    if ($request->filled('is_ai_generated')) {
        $query->where('is_ai_generated', $request->is_ai_generated === 'true');
    }

    // Show trashed records if requested
    if ($request->filled('trashed')) {
        if ($request->trashed === 'only') {
            $query->onlyTrashed();
        } elseif ($request->trashed === 'with') {
            $query->withTrashed();
        }
    } else {
        $query->whereNull('deleted_at');
    }

    // Sort by
    $sortBy = $request->sort_by ?? 'created_at';
    $sortOrder = $request->sort_order ?? 'desc';
    
    $allowedSorts = ['id', 'title', 'status', 'work_type', 'employment_type', 'published_at', 'closing_at', 'created_at', 'updated_at', 'deleted_at'];
    if (in_array($sortBy, $allowedSorts)) {
        $query->orderBy($sortBy, $sortOrder);
    }

    // Paginate
    $perPage = $request->per_page ?? 10;
    $jobs = $query->paginate($perPage);

    // Get statistics (filtered for the employer)
    $stats = [
        'total' => $employerId ? JobPost::where('employer_id', $employerId)->count() : 0,
        'published' => $employerId ? JobPost::where('employer_id', $employerId)->where('status', 'published')->count() : 0,
        'draft' => $employerId ? JobPost::where('employer_id', $employerId)->where('status', 'draft')->count() : 0,
        'archived' => $employerId ? JobPost::where('employer_id', $employerId)->where('status', 'archived')->count() : 0,
        'active' => $employerId ? JobPost::where('employer_id', $employerId)->active()->count() : 0,
        'public' => $employerId ? JobPost::where('employer_id', $employerId)->where('visibility', 'public')->count() : 0,
        'private' => $employerId ? JobPost::where('employer_id', $employerId)->where('visibility', 'private')->count() : 0,
        'ai_generated' => $employerId ? JobPost::where('employer_id', $employerId)->where('is_ai_generated', true)->count() : 0,
        'trashed' => $employerId ? JobPost::where('employer_id', $employerId)->onlyTrashed()->count() : 0,
    ];

    // Get employers for filter (only the admin's employer)
    if ($employerId) {
        $employers = Employer::where('id', $employerId)->select('id', 'company_name')->get();
    } else {
        $employers = collect();
    }
    
    // Get unique work types (filtered by employer)
    if ($employerId) {
        $workTypes = JobPost::where('employer_id', $employerId)
            ->select('work_type')
            ->distinct()
            ->whereNotNull('work_type')
            ->pluck('work_type');
            
        $employmentTypes = JobPost::where('employer_id', $employerId)
            ->select('employment_type')
            ->distinct()
            ->whereNotNull('employment_type')
            ->pluck('employment_type');
    } else {
        $workTypes = collect();
        $employmentTypes = collect();
    }

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'data' => $jobs,
            'stats' => $stats,
            'employers' => $employers,
            'work_types' => $workTypes,
            'employment_types' => $employmentTypes
        ]);
    }

    return view('admin.pages.jobs.index', compact('jobs', 'stats', 'employers', 'workTypes', 'employmentTypes'));
}

    /**
     * Show the form for creating a new job post
     */
    public function create()
    {


        return view('employer.pages.jobs.create');
    }

    /**
     * Store a newly created job post in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'employment_type' => 'required|in:full_time,part_time,contract,freelance,internship',
            'experience_level' => 'nullable|in:entry_level,mid_level,senior_level,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'currency' => 'nullable|string|size:3',
            'required_skills' => 'nullable|string',
            'preferred_skills' => 'nullable|string',
            'education_requirement' => 'nullable|string|max:255',
            'employer_id' => 'required|exists:employers,id',
            'recruiter_id' => 'nullable|exists:users,id',
            'visibility' => 'required|in:public,private,internal',
            'status' => 'required|in:draft,published,archived',
            'is_ai_generated' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'closing_at' => 'nullable|date|after:published_at',
            'max_applications' => 'nullable|integer|min:1',
            // Questions validation
            'questions' => 'nullable|array',
            'questions.*.question' => 'required_with:questions|string|max:500',
            'questions.*.type' => 'required_with:questions|in:text,textarea,select,checkbox,radio',
            'questions.*.required' => 'nullable|boolean',
            'questions.*.options' => 'nullable|string', // Changed from array to string
            'questions.*.order' => 'nullable|integer|min:0',
        ]);

        // Set default values
        $validated['is_ai_generated'] = $validated['is_ai_generated'] ?? false;
        $validated['currency'] = $validated['currency'] ?? 'USD';

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

        // Set published_at if status is published
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Convert comma-separated skills to array and then to JSON
        if (isset($validated['required_skills']) && !empty($validated['required_skills'])) {
            $skillsArray = array_filter(array_map('trim', explode(',', $validated['required_skills'])));
            $validated['required_skills'] = json_encode($skillsArray);
        } else {
            $validated['required_skills'] = json_encode([]);
        }

        if (isset($validated['preferred_skills']) && !empty($validated['preferred_skills'])) {
            $skillsArray = array_filter(array_map('trim', explode(',', $validated['preferred_skills'])));
            $validated['preferred_skills'] = json_encode($skillsArray);
        } else {
            $validated['preferred_skills'] = json_encode([]);
        }

        // Extract questions and remove from validated data
        $questionsData = $validated['questions'] ?? [];
        unset($validated['questions']);

        // Create the job post
        $job = JobPost::create($validated);

        // Create questions for the job post
        if (!empty($questionsData)) {
            foreach ($questionsData as $index => $questionData) {
                // Process options - convert comma-separated string to array
                $options = null;
                if (isset($questionData['options']) && !empty($questionData['options'])) {
                    $optionsArray = array_filter(array_map('trim', explode(',', $questionData['options'])));
                    $options = json_encode($optionsArray);
                }

                $job->questions()->create([
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'required' => $questionData['required'] ?? false,
                    'options' => $options,
                    'order' => $questionData['order'] ?? $index,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post created successfully',
                'data' => $job->load('questions')
            ], 201);
        }

        flash()->success('Job post created successfully');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Display the specified job post
     */
    public function show($id)
    {
        $job = JobPost::with([
            'employer',
            'recruiter',
            'applications' => function($q) {
                $q->latest()->limit(10);
            },
            'applications.applicant'
        ])->findOrFail($id);

        // Get statistics
        $stats = [
            'total_applications' => $job->applications()->count(),
            'pending_applications' => $job->applications()->where('status', 'pending')->count(),
            'shortlisted' => $job->applications()->where('status', 'shortlisted')->count(),
            'interviewing' => $job->applications()->where('status', 'interviewing')->count(),
            'hired' => $job->applications()->where('status', 'hired')->count(),
            'rejected' => $job->applications()->where('status', 'rejected')->count(),
        ];

        return view('employer.pages.jobs.show', compact('job', 'stats'));
    }

    /**
     * Show the form for editing the specified job post
     */
    public function edit($id)
    {
        $job = JobPost::findOrFail($id);
        $employers = Employer::select('id', 'company_name')->orderBy('company_name')->get();
        $recruiters = User::where('user_type', 'recruiter')->select('id', 'first_name', 'last_name')->get();

        return view('employer.pages.jobs.edit', compact('job', 'employers', 'recruiters'));
    }

    /**
     * Update the specified job post in storage
     */
    public function update(Request $request, $id)
    {
        $job = JobPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'employment_type' => 'required|in:full_time,part_time,contract,freelance,internship',
            'experience_level' => 'nullable|in:entry_level,mid_level,senior_level,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'currency' => 'nullable|string|size:3',
            'required_skills' => 'nullable|string',
            'preferred_skills' => 'nullable|string',
            'education_requirement' => 'nullable|string|max:255',
            'employer_id' => 'required|exists:employers,id',
            'recruiter_id' => 'nullable|exists:users,id',
            'visibility' => 'required|in:public,private,internal',
            'status' => 'required|in:draft,published,archived',
            'is_ai_generated' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'closing_at' => 'nullable|date|after:published_at',
            'max_applications' => 'nullable|integer|min:1',
            // Questions validation
            'questions' => 'nullable|array',
            'questions.*.id' => 'nullable|exists:job_post_questions,id',
            'questions.*.question' => 'required_with:questions|string|max:500',
            'questions.*.type' => 'required_with:questions|in:text,textarea,select,checkbox,radio',
            'questions.*.required' => 'nullable|boolean',
            'questions.*.options' => 'nullable|string', // Changed from array to string
            'questions.*.order' => 'nullable|integer|min:0',
            // For deleting questions
            'deleted_question_ids' => 'nullable|array',
            'deleted_question_ids.*' => 'exists:job_post_questions,id',
        ]);

        // Set published_at if status is published
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Convert comma-separated skills to array and then to JSON
        if (isset($validated['required_skills']) && !empty($validated['required_skills'])) {
            $skillsArray = array_filter(array_map('trim', explode(',', $validated['required_skills'])));
            $validated['required_skills'] = json_encode($skillsArray);
        } else {
            $validated['required_skills'] = json_encode([]);
        }

        if (isset($validated['preferred_skills']) && !empty($validated['preferred_skills'])) {
            $skillsArray = array_filter(array_map('trim', explode(',', $validated['preferred_skills'])));
            $validated['preferred_skills'] = json_encode($skillsArray);
        } else {
            $validated['preferred_skills'] = json_encode([]);
        }

        // Extract questions and deleted IDs
        $questionsData = $validated['questions'] ?? [];
        $deletedQuestionIds = $validated['deleted_question_ids'] ?? [];
        unset($validated['questions']);
        unset($validated['deleted_question_ids']);

        // Update the job post
        $job->update($validated);

        // Delete removed questions
        if (!empty($deletedQuestionIds)) {
            $job->questions()->whereIn('id', $deletedQuestionIds)->delete();
        }

        // Update or create questions
        if (!empty($questionsData)) {
            foreach ($questionsData as $index => $questionData) {
                // Process options - convert comma-separated string to array
                $options = null;
                if (isset($questionData['options']) && !empty($questionData['options'])) {
                    // Split by comma, trim whitespace, filter out empty values
                    $optionsArray = array_filter(array_map('trim', explode(',', $questionData['options'])));
                    $options = json_encode($optionsArray);
                }

                $questionPayload = [
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'required' => $questionData['required'] ?? false,
                    'options' => $options,
                    'order' => $questionData['order'] ?? $index,
                ];

                if (isset($questionData['id'])) {
                    // Update existing question
                    $job->questions()->where('id', $questionData['id'])->update($questionPayload);
                } else {
                    // Create new question
                    $job->questions()->create($questionPayload);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post updated successfully',
                'data' => $job->load('questions')
            ]);
        }

        flash()->success('Job post updated successfully');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Remove the specified job post from storage
     */
     public function destroy($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post moved to trash successfully'
            ]);
        }

        flash()->success('Job post moved to trash successfully');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Restore a soft-deleted job post
     */
    public function restore($id)
    {
        $job = JobPost::onlyTrashed()->findOrFail($id);
        $job->restore();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post restored successfully'
            ]);
        }

        flash()->success('Job post restored successfully');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Permanently delete a job post
     */
    public function forceDelete($id)
    {
        $job = JobPost::onlyTrashed()->findOrFail($id);
        
        // Delete related records if needed
        $job->questions()->delete();
        
        $job->forceDelete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post permanently deleted'
            ]);
        }

        flash()->success('Job post permanently deleted');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Bulk delete job posts
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:job_posts,id'
        ]);

        $deleted = JobPost::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} job posts deleted successfully"
        ]);
    }

    /**
     * Bulk update job status
     */
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:job_posts,id',
            'status' => 'required|in:draft,published,archived'
        ]);

        $updated = JobPost::whereIn('id', $request->ids)->update([
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} job posts updated successfully"
        ]);
    }

    /**
     * Toggle job status (publish/unpublish)
     */
    public function toggleStatus($id)
    {
        $job = JobPost::findOrFail($id);

        if ($job->status === 'published') {
            $job->status = 'draft';
            $job->published_at = null;
            $message = 'Job unpublished successfully';
        } else {
            $job->status = 'published';
            $job->published_at = now();
            $message = 'Job published successfully';
        }

        $job->save();

        flash()->success($message);
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Toggle job visibility
     */
    public function toggleVisibility($id)
    {
        $job = JobPost::findOrFail($id);

        $job->visibility = $job->visibility === 'public' ? 'private' : 'public';
        $job->save();

        

        flash()->success('Job visibility updated to'. $job->visibility);
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Duplicate a job post
     */
    public function duplicate($id)
    {
        $originalJob = JobPost::findOrFail($id);

        $newJob = $originalJob->replicate();
        $newJob->title = $originalJob->title . ' (Copy)';
        // $newJob->slug = Str::slug($newJob->title) . '-' . Str::random(6);
        $newJob->status = 'draft';
        $newJob->published_at = null;
        $newJob->created_at = now();
        $newJob->updated_at = now();
        $newJob->save();

        return response()->json([
            'success' => true,
            'message' => 'Job duplicated successfully',
            'data' => $newJob
        ]);

        flash()->success('Job duplicated successfully');
        return redirect()->route('employer.jobs.index');
    }

    /**
     * Get job statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => JobPost::count(),
            'by_status' => [
                'published' => JobPost::where('status', 'published')->count(),
                'draft' => JobPost::where('status', 'draft')->count(),
                'archived' => JobPost::where('status', 'archived')->count(),
            ],
            'by_work_type' => [
                'remote' => JobPost::where('work_type', 'remote')->count(),
                'onsite' => JobPost::where('work_type', 'onsite')->count(),
                'hybrid' => JobPost::where('work_type', 'hybrid')->count(),
            ],
            'by_employment_type' => [
                'full_time' => JobPost::where('employment_type', 'full_time')->count(),
                'part_time' => JobPost::where('employment_type', 'part_time')->count(),
                'contract' => JobPost::where('employment_type', 'contract')->count(),
                'freelance' => JobPost::where('employment_type', 'freelance')->count(),
                'internship' => JobPost::where('employment_type', 'internship')->count(),
            ],
            'by_visibility' => [
                'public' => JobPost::where('visibility', 'public')->count(),
                'private' => JobPost::where('visibility', 'private')->count(),
                'internal' => JobPost::where('visibility', 'internal')->count(),
            ],
            'active' => JobPost::active()->count(),
            'ai_generated' => JobPost::where('is_ai_generated', true)->count(),
            'recent' => JobPost::with('employer')->latest()->limit(5)->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Export job posts
     */
    public function export(Request $request)
    {
        $query = JobPost::with('employer');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        if ($request->filled('employer_id')) {
            $query->where('employer_id', $request->employer_id);
        }

        $jobs = $query->get([
            'title',
            'department',
            'location',
            'work_type',
            'employment_type',
            'salary_min',
            'salary_max',
            'currency',
            'status',
            'visibility',
            'published_at',
            'closing_at',
            'created_at'
        ]);

        $filename = 'jobs_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ];

        $callback = function() use ($jobs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Title', 'Department', 'Location', 'Work Type', 'Employment Type',
                'Salary Min', 'Salary Max', 'Currency', 'Status', 'Visibility',
                'Published At', 'Closing At', 'Created At'
            ]);

            foreach ($jobs as $job) {
                fputcsv($handle, [
                    $job->title,
                    $job->department,
                    $job->location,
                    $job->work_type,
                    $job->employment_type,
                    $job->salary_min,
                    $job->salary_max,
                    $job->currency,
                    $job->status,
                    $job->visibility,
                    $job->published_at?->format('Y-m-d H:i:s'),
                    $job->closing_at?->format('Y-m-d H:i:s'),
                    $job->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
