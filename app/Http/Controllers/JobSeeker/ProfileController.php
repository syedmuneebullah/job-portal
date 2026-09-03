<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\ApplicantEducation;
use App\Models\ApplicantExperience;
use App\Models\ApplicantCertificate;
use App\Models\ApplicantProfile;

class ProfileController extends Controller
{
    public function Profile()
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
            },
            'educations', 
            'experiences', 
            'certificates'
        ])->find(Auth::id());

        // Don't convert to arrays - keep as Eloquent collections
        // The collections will be automatically converted to objects in Blade

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

        return view('jobseeker.pages.profile', compact('user', 'stats', 'recentActivity'));
    }

    public function EditProfile()
    {
        $user = User::with('applicantProfile')->find(Auth::id());
        
        if (!$user->applicantProfile) {
            $applicantProfile = ApplicantProfile::create([
                'user_id' => $user->id,
                'is_visible' => true,
                'currency' => 'USD',
            ]);
            $user->load('applicantProfile');
        }
        
        return view('jobseeker.pages.edit-profile', compact('user'));
    }

    public function UpdateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        
        $validatedUser = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validatedUser['profile_photo'] = $path;
        }
        
        $user->update($validatedUser);

        $validatedProfile = $request->validate([
            'title' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'current_job_title' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'languages' => 'nullable|string',
            'interests' => 'nullable|string',
            'resume_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'portfolio_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'preferred_work_type' => 'nullable|in:remote,onsite,hybrid',
            'preferred_locations' => 'nullable|string',
            'salary_expectation_min' => 'nullable|numeric|min:0',
            'salary_expectation_max' => 'nullable|numeric|min:0|gte:salary_expectation_min',
            'currency' => 'nullable|string|size:3',
            'is_visible' => 'nullable|boolean',
        ]);

        if (isset($validatedProfile['skills'])) {
            $validatedProfile['skills'] = array_filter(array_map('trim', explode(',', $validatedProfile['skills'])));
        }
        
        if (isset($validatedProfile['languages'])) {
            $validatedProfile['languages'] = array_filter(array_map('trim', explode(',', $validatedProfile['languages'])));
        }
        
        if (isset($validatedProfile['interests'])) {
            $validatedProfile['interests'] = array_filter(array_map('trim', explode(',', $validatedProfile['interests'])));
        }
        
        if (isset($validatedProfile['preferred_locations'])) {
            $validatedProfile['preferred_locations'] = array_filter(array_map('trim', explode(',', $validatedProfile['preferred_locations'])));
        }

        if ($request->hasFile('resume_path')) {
            $profile = $user->applicantProfile;
            if ($profile && $profile->resume_path) {
                Storage::delete('public/' . $profile->resume_path);
            }
            
            $path = $request->file('resume_path')->store('resumes', 'public');
            $validatedProfile['resume_path'] = $path;
        }

        $user->applicantProfile()->update($validatedProfile);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);
        }

        return redirect()->route('candidate.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // ===== EDUCATION METHODS =====
    
    public function storeEducation(Request $request)
    {
        try {
            $validated = $request->validate([
                'institute_name' => 'nullable|string|max:255',
                'education_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $validated['user_id'] = Auth::id();
            $validated['on_going'] = $request->has('on_going') ? 'yes' : 'no';

            $education = ApplicantEducation::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Education added successfully',
                'data' => $education
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updateEducation(Request $request, $id)
    {
        try {
            $education = ApplicantEducation::where('user_id', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'institute_name' => 'nullable|string|max:255',
                'education_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $validated['on_going'] = $request->has('on_going') ? 'no' : 'yes';
            $education->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Education updated successfully',
                'data' => $education
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroyEducation($id)
    {
        try {
            $education = ApplicantEducation::where('user_id', Auth::id())->findOrFail($id);
            $education->delete();

            return response()->json([
                'success' => true,
                'message' => 'Education deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // ===== EXPERIENCE METHODS =====
    
    public function storeExperience(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $validated['user_id'] = Auth::id();

            $experience = ApplicantExperience::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Experience added successfully',
                'data' => $experience
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updateExperience(Request $request, $id)
    {
        try {
            $experience = ApplicantExperience::where('user_id', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'company_name' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $experience->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Experience updated successfully',
                'data' => $experience
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroyExperience($id)
    {
        try {
            $experience = ApplicantExperience::where('user_id', Auth::id())->findOrFail($id);
            $experience->delete();

            return response()->json([
                'success' => true,
                'message' => 'Experience deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // ===== CERTIFICATE METHODS =====
    
    public function storeCertificate(Request $request)
    {
        try {
            $validated = $request->validate([
                'institute_name' => 'nullable|string|max:255',
                'sertification_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $validated['user_id'] = Auth::id();
            $validated['on_going'] = $request->has('on_going') ? 'yes' : 'no';

            $certificate = ApplicantCertificate::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Certificate added successfully',
                'data' => $certificate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function updateCertificate(Request $request, $id)
    {
        try {
            $certificate = ApplicantCertificate::where('user_id', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'institute_name' => 'nullable|string|max:255',
                'sertification_title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'on_going' => 'nullable|boolean',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
            ]);

            $validated['on_going'] = $request->has('on_going') ? 'yes' : 'no';
            $certificate->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully',
                'data' => $certificate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroyCertificate($id)
    {
        try {
            $certificate = ApplicantCertificate::where('user_id', Auth::id())->findOrFail($id);
            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}