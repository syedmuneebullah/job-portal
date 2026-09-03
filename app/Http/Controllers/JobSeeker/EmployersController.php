<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\JobPost;

class EmployersController extends Controller
{
    /**
     * Display a listing of employers for job seekers
     */
    public function index(Request $request)
    {
        $query = Employer::query()
            ->with(['user' => function($q) {
                $q->select('id', 'first_name', 'last_name', 'email', 'phone', 'profile_photo', 'status');
            }])
            ->whereNull('deleted_at')
            ->where('verification_status', 'verified');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'LIKE', "%{$search}%")
                  ->orWhere('industry', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($user) use ($search) {
                      $user->where('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by industry
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        // Filter by company size
        if ($request->filled('company_size')) {
            $query->where('company_size', $request->company_size);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $allowedSorts = ['id', 'company_name', 'industry', 'created_at', 'rating'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $request->per_page ?? 12;
        $employers = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => Employer::where('verification_status', 'verified')->count(),
            'industries' => Employer::where('verification_status', 'verified')
                ->distinct()
                ->whereNotNull('industry')
                ->count('industry'),
            'featured' => Employer::where('verification_status', 'verified')
                ->count(),
        ];

        // Get industries for filter
        $industries = Employer::where('verification_status', 'verified')
            ->whereNotNull('industry')
            ->distinct()
            ->pluck('industry');

        // Get company sizes for filter
        $companySizes = ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'];

        return view('jobseeker.pages.employers', compact('employers', 'stats', 'industries', 'companySizes'));
    }

    /**
     * Display the specified employer details
     */
    public function show($id)
    {
        $employer = Employer::with(['user' => function($q) {
            $q->select('id', 'first_name', 'last_name', 'email', 'phone', 'profile_photo', 'status');
        }])
        ->where('verification_status', 'verified')
        ->whereNull('deleted_at')
        ->findOrFail($id);

        // Get jobs posted by this employer
        $jobs = JobPost::where('employer_id', $id)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get job statistics
        $jobStats = [
            'total' => JobPost::where('employer_id', $id)
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->count(),
            'active' => JobPost::where('employer_id', $id)
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->where(function($q) {
                    $q->whereNull('closing_at')
                      ->orWhere('closing_at', '>=', now());
                })
                ->count(),
            'recent' => JobPost::where('employer_id', $id)
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->latest()
                ->take(3)
                ->get(),
        ];

        // Get similar employers
        $similarEmployers = Employer::where('verification_status', 'verified')
            ->whereNull('deleted_at')
            ->where('id', '!=', $id)
            ->where(function($q) use ($employer) {
                $q->where('industry', $employer->industry)
                  ->orWhere('company_size', $employer->company_size);
            })
            ->take(4)
            ->get();

        return view('jobseeker.pages.employer', compact('employer', 'jobs', 'jobStats', 'similarEmployers'));
    }

    /**
     * Get featured employers
     */
    public function featured(Request $request)
    {
        $employers = Employer::where('verification_status', 'verified')
            ->whereNull('deleted_at')
            ->with(['user' => function($q) {
                $q->select('id', 'first_name', 'last_name', 'email', 'phone', 'profile_photo', 'status');
            }])
            ->latest()
            ->paginate(6);

        return view('jobseeker.pages.employers.featured', compact('employers'));
    }

    /**
     * Get employer jobs
     */
    public function employerJobs($id, Request $request)
    {
        $employer = Employer::where('verification_status', 'verified')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        $query = JobPost::where('employer_id', $id)
            ->where('status', 'published')
            ->whereNull('deleted_at');

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('jobseeker.pages.employers.jobs', compact('employer', 'jobs'));
    }
}