<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\User;
use Illuminate\Validation\Rules\Password; 

class ProfileController extends Controller
{
    /**
     * Show the company profile (view page).
     */
    public function show()
    {
        $employer = Employer::where('user_id', Auth::id())->firstOrFail();

        // Stats
        $jobIds = JobPost::where('employer_id', $employer->id)->pluck('id');

        $stats = [
            'total_jobs'         => $jobIds->count(),
            'active_jobs'        => JobPost::where('employer_id', $employer->id)
                                        ->where('status', 'published')
                                        ->whereNull('deleted_at')
                                        ->count(),
            'total_applications' => Application::whereIn('job_post_id', $jobIds)->count(),
        ];

        // Recent jobs (for a small preview on the profile)
        $recentJobs = JobPost::where('employer_id', $employer->id)
            ->whereNull('deleted_at')
            ->latest()
            ->limit(5)
            ->get();

        return view('employer.pages.profile', compact('employer', 'stats', 'recentJobs'));
    }

    /**
     * Show the edit profile form.
     */
    public function edit()
    {
        $employer = Employer::where('user_id', Auth::id())->firstOrFail();

        return view('employer.pages.edit-profile', compact('employer'));
    }

    /**
     * Update the company profile.
     */
    public function update(Request $request)
    {
        $employer = Employer::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'company_name'        => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:employers,email,' . $employer->id,
            'phone'               => 'nullable|string|max:30',
            'company_description' => 'nullable|string|max:5000',
            'website'             => 'nullable|url|max:255',
            'industry'            => 'nullable|string|max:255',
            'company_size'        => 'nullable|string|max:50',
            'founded_year'        => 'nullable|integer|min:1800|max:' . date('Y'),
            'headquarters'        => 'nullable|string|max:255',
            'linkedin_url'        => 'nullable|url|max:255',
            'twitter_url'         => 'nullable|url|max:255',
            'company_logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'company_name.required' => 'Company name is required.',
            'email.required'        => 'A contact email is required.',
            'email.unique'          => 'This email is already used by another employer.',
            'founded_year.max'      => 'Founded year cannot be in the future.',
            'company_logo.image'    => 'The logo must be an image file.',
            'company_logo.max'      => 'Logo size must be under 2MB.',
        ]);

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            if ($employer->company_logo) {
                Storage::disk('public')->delete($employer->company_logo);
            }

            $path = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $path;
        }

        $employer->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Company profile updated successfully.',
                'employer' => $employer->fresh(),
            ]);
        }

        return redirect()
            ->route('employer.profile')
            ->with('success', 'Company profile updated successfully!');
    }

    /**
     * Remove the company logo.
     */
    public function removeLogo(Request $request)
    {
        $employer = Employer::where('user_id', Auth::id())->firstOrFail();

        if ($employer->company_logo) {
            Storage::disk('public')->delete($employer->company_logo);
            $employer->update(['company_logo' => null]);
        }

        return back()->with('success', 'Company logo removed.');
    }

        /**
 * Show the change password page.
 */
public function showChangePassword()
{
    $user = User::find(Auth::id());

    return view('employer.pages.change-password', compact('user'));
}

/**
 * Update the user's password.
 */
public function updatePassword(Request $request)
{
    $user = User::find(Auth::id());

    $validated = $request->validate([
        'current_password' => ['required', 'string'],
        'password' => [
            'required',
            'string',
            'confirmed',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
        ],
    ], [
        'current_password.required' => 'Please enter your current password.',
        'password.required'         => 'Please enter a new password.',
        'password.confirmed'        => 'The password confirmation does not match.',
        'password.min'              => 'Password must be at least 8 characters.',
    ]);

    // Verify current password matches
    if (!Hash::check($validated['current_password'], $user->password)) {
        return back()
            ->withErrors(['current_password' => 'Your current password is incorrect.'])
            ->withInput();
    }

    // Prevent reusing the same password
    if (Hash::check($validated['password'], $user->password)) {
        return back()
            ->withErrors(['password' => 'New password must be different from your current password.'])
            ->withInput();
    }

    // Update password
    $user->update([
        'password' => Hash::make($validated['password']),
    ]);

    // Optional: log the user out of other sessions for security
    // Auth::logoutOtherDevices($validated['password']);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }

    return redirect()
        ->route('employer.profile')
        ->with('success', 'Your password has been changed successfully.');
}
}