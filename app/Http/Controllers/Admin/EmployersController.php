<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployersController extends Controller
{
    /**
     * Display a listing of employers with search and pagination
     */
    public function index(Request $request)
    {
        $query = Employer::query()
            ->with(['user' => function($q) {
                $q->select('id', 'first_name', 'last_name', 'email', 'phone', 'profile_photo', 'status');
            }])
            ->select([
                'employers.id',
                'employers.user_id',
                'employers.email',
                'employers.phone',
                'employers.company_name',
                'employers.company_logo',
                'employers.industry',
                'employers.company_size',
                'employers.verification_status',
                'employers.created_at',
                'employers.verified_at',
                'employers.deleted_at',
            ]);

        // Show trashed records filter
        if ($request->filled('trashed')) {
            if ($request->trashed === 'only') {
                $query->onlyTrashed(); // Show only deleted
            } elseif ($request->trashed === 'with') {
                $query->withTrashed(); // Show all including deleted
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employers.company_name', 'LIKE', "%{$search}%")
                ->orWhere('employers.industry', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function($user) use ($search) {
                    $user->where('email', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            });
        }

        // Filter by verification status
        if ($request->filled('verification_status')) {
            $query->where('employers.verification_status', $request->verification_status);
        }

        // Filter by industry
        if ($request->filled('industry')) {
            $query->where('employers.industry', $request->industry);
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $allowedSorts = ['id', 'company_name', 'industry', 'verification_status', 'created_at', 'deleted_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $request->per_page ?? 10;
        $employers = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => Employer::count(),
            'trashed' => Employer::onlyTrashed()->count(),
            'verified' => Employer::where('verification_status', 'verified')->count(),
            'pending' => Employer::where('verification_status', 'pending')->count(),
            'rejected' => Employer::where('verification_status', 'rejected')->count(),
        ];

        $industries = Employer::select('industry')
            ->whereNotNull('industry')
            ->distinct()
            ->pluck('industry');

        return view('admin.pages.employers.index', compact('employers', 'stats', 'industries'));
    }

    /**
     * Show the form for creating a new employer
     */
    public function create()
    {
        return view('admin.employers.create');
    }

    /**
     * Store a newly created employer in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'company_description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'headquarters' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ]);

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $path;
        }

        $employer = Employer::create([
            ...$validated,
            'password' => bcrypt($validated['password']),
            'user_type' => 'employer',
            'status' => 'active',
            'verification_status' => 'pending',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Employer created successfully',
                'data' => $employer
            ], 201);
        }

        return redirect()->route('admin.employers.index')
            ->with('success', 'Employer created successfully');
    }

    /**
     * Display the specified employer
     */
    public function show($id)
    {
        $employer = Employer::with(['jobPosts' => function ($query) {
            $query->select('id', 'employer_id', 'title', 'status', 'created_at')
                ->latest();
        }])->findOrFail($id);

        // Get statistics with proper table qualification
        $stats = [
            'total_jobs' => $employer->jobPosts()->count(),
            'active_jobs' => $employer->jobPosts()->where('status', 'published')->count(),
            'draft_jobs' => $employer->jobPosts()->where('status', 'draft')->count(),
            'archived_jobs' => $employer->jobPosts()->where('status', 'archived')->count(),
            'total_applications' => $employer->jobPosts()->withCount('applications')->get()->sum('applications_count'),
            
            // Fix: Specify table name for status column
            'pending_applications' => $employer->applications()->where('applications.status', 'pending')->count(),
            'shortlisted_applications' => $employer->applications()->where('applications.status', 'shortlisted')->count(),
            'hired_applications' => $employer->applications()->where('applications.status', 'hired')->count(),
            'rejected_applications' => $employer->applications()->where('applications.status', 'rejected')->count(),
        ];

        return view('admin.pages.employers.show', compact('employer', 'stats'));
    }

    /**
     * Show the form for editing the specified employer
     */
    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        return view('admin.pages.employers.edit', compact('employer'));
    }

    /**
     * Update the specified employer in storage
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $employer = Employer::findOrFail($id);

        $validated = $request->validate([
            'email' => 'required|email|unique:employers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'company_description' => 'nullable|string',
            'website' => 'nullable|url',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'headquarters' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'status' => 'nullable|in:pending,active,suspended,rejected',
            'verification_status' => 'nullable|in:pending,verified,rejected',
        ]);


        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            if ($employer->company_logo) {
                \Storage::disk('public')->delete($employer->company_logo);
            }
            $path = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $path;
        }

        // If verified, set verified_at
        if ($request->verification_status === 'verified' && $employer->verification_status !== 'verified') {
            $validated['verified_at'] = now();
        }

        $employer->update($validated);

        // if ($request->ajax()) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Employer updated successfully',
        //         'data' => $employer
        //     ]);
        // }
        flash()->success('Employer Details Updated');
        return redirect()->route('employers.index');
    }

    /**
     * Remove the specified employer from storage
     */
    public function destroy($id)
    {
        $employer = Employer::findOrFail($id);
        

        $companyName = $employer->company_name;
    
        // Soft delete (just sets deleted_at timestamp)
        $employer->delete();

        flash()->success("Company '{$companyName}' has been moved to trash");
        return redirect()->route('employers.index');
    }

    public function restore($id)
    {
        $employer = Employer::withTrashed()->findOrFail($id);
        $companyName = $employer->company_name;
        
        $employer->restore();

        flash()->success("Company '{$companyName}' has been restored successfully");
        return redirect()->route('employers.index');
    }

    /**
     * Permanently delete an employer
     */
    public function forceDelete($id)
    {
        $employer = Employer::withTrashed()->findOrFail($id);
        $companyName = $employer->company_name;
        
        // Delete logo from storage
        if ($employer->company_logo) {
            \Storage::disk('public')->delete($employer->company_logo);
        }

        // Permanently delete from database
        $employer->forceDelete();

        flash()->success("Company '{$companyName}' has been permanently deleted");
        return redirect()->route('employers.index');
    }

    /**
     * Bulk delete employers
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:employers,id'
        ]);

        $deleted = Employer::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} employers deleted successfully"
        ]);
    }

    /**
     * Export employers data
     */
    public function export(Request $request)
    {
        $query = Employer::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }

        $employers = $query->get(['first_name', 'last_name', 'email', 'company_name', 'industry', 'verification_status', 'status', 'created_at']);

        // Return as CSV or Excel
        // Implementation depends on your export library
    }

    /**
     * Get employer statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Employer::count(),
            'active' => Employer::where('status', 'active')->count(),
            'pending' => Employer::where('status', 'pending')->count(),
            'suspended' => Employer::where('status', 'suspended')->count(),
            'verified' => Employer::where('verification_status', 'verified')->count(),
            'pending_verification' => Employer::where('verification_status', 'pending')->count(),
            'rejected' => Employer::where('verification_status', 'rejected')->count(),
            'industries' => Employer::select('industry')
                ->whereNotNull('industry')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->industry,
                        'count' => Employer::where('industry', $item->industry)->count()
                    ];
                })
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}