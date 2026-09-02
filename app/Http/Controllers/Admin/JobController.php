<?php

namespace App\Http\Controllers\Admin;

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

        // Sort by
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        $allowedSorts = ['id', 'title', 'status', 'work_type', 'employment_type', 'published_at', 'closing_at', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $perPage = $request->per_page ?? 10;
        $jobs = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => JobPost::count(),
            'published' => JobPost::where('status', 'published')->count(),
            'draft' => JobPost::where('status', 'draft')->count(),
            'archived' => JobPost::where('status', 'archived')->count(),
            'active' => JobPost::active()->count(),
            'public' => JobPost::where('visibility', 'public')->count(),
            'private' => JobPost::where('visibility', 'private')->count(),
            'ai_generated' => JobPost::where('is_ai_generated', true)->count(),
        ];

        // Get employers for filter
        $employers = Employer::select('id', 'company_name')->orderBy('company_name')->get();
        
        // Get unique work types
        $workTypes = JobPost::select('work_type')->distinct()->whereNotNull('work_type')->pluck('work_type');
        $employmentTypes = JobPost::select('employment_type')->distinct()->whereNotNull('employment_type')->pluck('employment_type');

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
        $employers = Employer::select('id', 'company_name')->orderBy('company_name')->get();
        $recruiters = User::where('user_type', 'recruiter')->select('id', 'first_name', 'last_name')->get();
        
        return view('admin.pages.jobs.create', compact('employers', 'recruiters'));
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
            'required_skills' => 'nullable|array',
            'required_skills.*' => 'string|max:255',
            'preferred_skills' => 'nullable|array',
            'preferred_skills.*' => 'string|max:255',
            'education_requirement' => 'nullable|string|max:255',
            'employer_id' => 'required|exists:employers,id',
            'recruiter_id' => 'nullable|exists:users,id',
            'visibility' => 'required|in:public,private,internal',
            'status' => 'required|in:draft,published,archived',
            'is_ai_generated' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'closing_at' => 'nullable|date|after:published_at',
            'max_applications' => 'nullable|integer|min:1',
            'application_questions' => 'nullable|array',
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

        // Convert skills to JSON
        if (isset($validated['required_skills'])) {
            $validated['required_skills'] = json_encode($validated['required_skills']);
        }
        if (isset($validated['preferred_skills'])) {
            $validated['preferred_skills'] = json_encode($validated['preferred_skills']);
        }
        if (isset($validated['application_questions'])) {
            $validated['application_questions'] = json_encode($validated['application_questions']);
        }

        $job = JobPost::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post created successfully',
                'data' => $job
            ], 201);
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post created successfully');
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

        return view('admin.pages.jobs.show', compact('job', 'stats'));
    }

    /**
     * Show the form for editing the specified job post
     */
    public function edit($id)
    {
        $job = JobPost::findOrFail($id);
        $employers = Employer::select('id', 'company_name')->orderBy('company_name')->get();
        $recruiters = User::where('user_type', 'recruiter')->select('id', 'first_name', 'last_name')->get();
        
        return view('admin.pages.jobs.edit', compact('job', 'employers', 'recruiters'));
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
            'required_skills' => 'nullable|array',
            'required_skills.*' => 'string|max:255',
            'preferred_skills' => 'nullable|array',
            'preferred_skills.*' => 'string|max:255',
            'education_requirement' => 'nullable|string|max:255',
            'employer_id' => 'required|exists:employers,id',
            'recruiter_id' => 'nullable|exists:users,id',
            'visibility' => 'required|in:public,private,internal',
            'status' => 'required|in:draft,published,archived',
            'is_ai_generated' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'closing_at' => 'nullable|date|after:published_at',
            'max_applications' => 'nullable|integer|min:1',
            'application_questions' => 'nullable|array',
        ]);

        // Set published_at if status is published
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Convert skills to JSON
        if (isset($validated['required_skills'])) {
            $validated['required_skills'] = json_encode($validated['required_skills']);
        }
        if (isset($validated['preferred_skills'])) {
            $validated['preferred_skills'] = json_encode($validated['preferred_skills']);
        }
        if (isset($validated['application_questions'])) {
            $validated['application_questions'] = json_encode($validated['application_questions']);
        }

        $job->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Job post updated successfully',
                'data' => $job
            ]);
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post updated successfully');
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
                'message' => 'Job post deleted successfully'
            ]);
        }

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post deleted successfully');
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
        return redirect()->route('admin.jobs.index');
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
        return redirect()->route('admin.jobs.index');
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

        flash()->success('Job duplicated successfully');
        return redirect()->route('admin.jobs.index');
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