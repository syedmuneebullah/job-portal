<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of users with search, filters, and pagination
     */
    public function index(Request $request)
    {
        // Base query with eager loading
        $query = User::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'email',
                'user_type',
                'status',
                'phone',
                'profile_photo',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('user_type', 'LIKE', "%{$search}%");
            });
        }

        // Filter by user type
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by verification
        if ($request->filled('verification')) {
            if ($request->verification === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verification === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        // Allowed sort columns (prevent SQL injection)
        $allowedSorts = ['id', 'first_name', 'last_name', 'email', 'user_type', 'status', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $perPage = $request->per_page ?? 10;
        $users = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => User::count(),
            'admins' => User::where('user_type', 'admin')->count(),
            'employers' => User::where('user_type', 'employer')->count(),
            'recruiters' => User::where('user_type', 'recruiter')->count(),
            'job_seekers' => User::where('user_type', 'job_seeker')->count(),
            'active' => User::where('status', 'active')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        // Get unique user types for filter
        $userTypes = User::select('user_type')->distinct()->pluck('user_type');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $users,
                'stats' => $stats,
                'user_types' => $userTypes
            ]);
        }

        return view('admin.pages.users.index', compact('users', 'stats', 'userTypes'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:admin,employer,recruiter,job_seeker',
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,active,suspended,rejected',
            'email_verified' => 'nullable|boolean',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'phone' => $validated['phone'] ?? null,
            'profile_photo' => $validated['profile_photo'] ?? null,
            'status' => $validated['status'],
            'email_verified_at' => isset($validated['email_verified']) && $validated['email_verified'] ? now() : null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with([
            'employer',
            'recruiter',
            'applicantProfile',
            'jobPosts' => function ($query) {
                $query->latest()->limit(5);
            },
            'applications' => function ($query) {
                $query->latest()->limit(5);
            }
        ])->findOrFail($id);

        // Get user statistics
        $stats = [
            'total_jobs' => $user->jobPosts()->count(),
            'active_jobs' => $user->jobPosts()->where('status', 'published')->count(),
            'draft_jobs' => $user->jobPosts()->where('status', 'draft')->count(),
            'archived_jobs' => $user->jobPosts()->where('status', 'archived')->count(),
            'total_applications' => $user->applications()->count(),
            'pending_applications' => $user->applications()->where('status', 'pending')->count(),
            'shortlisted_applications' => $user->applications()->where('status', 'shortlisted')->count(),
            'hired_applications' => $user->applications()->where('status', 'hired')->count(),
            'rejected_applications' => $user->applications()->where('status', 'rejected')->count(),
        ];

        // Get recent activity
        $recentActivity = collect()
            ->merge($user->jobPosts()->latest()->limit(5)->get()->map(function($job) {
                return [
                    'type' => 'job_posted',
                    'title' => $job->title,
                    'created_at' => $job->created_at,
                ];
            }))
            ->merge($user->applications()->latest()->limit(5)->get()->map(function($application) {
                return [
                    'type' => 'application_submitted',
                    'title' => $application->jobPost->title ?? 'N/A',
                    'created_at' => $application->created_at,
                ];
            }))
            ->sortByDesc('created_at')
            ->take(10);

        return view('admin.pages.users.show', compact('user', 'stats', 'recentActivity'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     */
    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048',
            'user_type' => 'required|in:admin,employer,recruiter,job_seeker',
            'status' => 'required|in:pending,active,suspended,rejected',
            'email_verified' => 'nullable|boolean',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        // Handle password update
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        // Handle email verification
        if (isset($validated['email_verified']) && $validated['email_verified']) {
            $validated['email_verified_at'] = now();
        } else {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage (Soft Delete)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->first_name . ' ' . $user->last_name;
        
        $user->delete();

        flash()->success("User '{$userName}' has been moved to trash");
        return redirect()->route('users.index');
    }

    /**
     * Restore a soft-deleted user
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $userName = $user->first_name . ' ' . $user->last_name;
        
        $user->restore();

        flash()->success("User '{$userName}' has been restored successfully");
        return redirect()->route('users.index');
    }

    /**
     * Permanently delete a user
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $userName = $user->first_name . ' ' . $user->last_name;
        
        // Delete profile photo
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->forceDelete();

        flash()->success("User '{$userName}' has been permanently deleted");
        return redirect()->route('users.index');
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        // Delete profile photos
        $users = User::whereIn('id', $request->ids)->get();
        foreach ($users as $user) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
        }

        $deleted = User::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} users deleted successfully"
        ]);
    }

    /**
     * Bulk update user status
     */
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'status' => 'required|in:pending,active,suspended,rejected'
        ]);

        $updated = User::whereIn('id', $request->ids)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} users updated successfully"
        ]);
    }

    /**
     * Verify user email
     */
    public function verifyEmail($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        $query = User::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->get([
            'first_name',
            'last_name',
            'email',
            'user_type',
            'status',
            'phone',
            'created_at'
        ]);

        // Return as CSV
        $filename = 'users_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\""
        ];

        $callback = function() use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['First Name', 'Last Name', 'Email', 'User Type', 'Status', 'Phone', 'Created At']);
            
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    $user->user_type,
                    $user->status,
                    $user->phone,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get user statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => User::count(),
            'by_type' => [
                'admin' => User::where('user_type', 'admin')->count(),
                'employer' => User::where('user_type', 'employer')->count(),
                'recruiter' => User::where('user_type', 'recruiter')->count(),
                'job_seeker' => User::where('user_type', 'job_seeker')->count(),
            ],
            'by_status' => [
                'active' => User::where('status', 'active')->count(),
                'pending' => User::where('status', 'pending')->count(),
                'suspended' => User::where('status', 'suspended')->count(),
                'rejected' => User::where('status', 'rejected')->count(),
            ],
            'verification' => [
                'verified' => User::whereNotNull('email_verified_at')->count(),
                'unverified' => User::whereNull('email_verified_at')->count(),
            ],
            'recent' => User::latest()->limit(5)->get(['id', 'first_name', 'last_name', 'email', 'created_at'])
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}