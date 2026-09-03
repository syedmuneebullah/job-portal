{{-- resources/views/jobseeker/pages/edit-profile.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Back link -->
    <a href="{{ route('candidate.profile') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1a237e] hover:underline mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to profile
    </a>

    <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-4">

            <!-- ===== PAGE HEADER ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900">Edit profile</h2>
                <p class="text-sm text-gray-500 mt-1">Update your professional information</p>
            </div>

            <!-- ===== PROFILE PHOTO + PERSONAL INFORMATION ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Personal information</h3>

                <div class="flex items-center gap-5 pb-6 border-b border-gray-100">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full border-4 border-gray-100 bg-gray-100 overflow-hidden" id="photoPreview">
                            @if($user->profile_photo)
                                <img src="{{ Storage::url($user->profile_photo) }}"
                                     alt="{{ $user->full_name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-[#1a237e] flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">{{ $user->initials }}</span>
                                </div>
                            @endif
                        </div>
                        <label for="profile_photo" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-white border border-gray-300 hover:bg-gray-50 flex items-center justify-center cursor-pointer shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">
                    </div>
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Profile photo</p>
                        <p class="text-xs text-gray-400">JPG, PNG or GIF. Max 2MB</p>
                        @error('profile_photo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('phone') border-red-500 @enderror"
                               placeholder="e.g. +60 12-345-6789">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== PROFESSIONAL SUMMARY ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Professional summary</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title / headline</label>
                        <input type="text" name="title" value="{{ old('title', $user->applicantProfile->title ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('title') border-red-500 @enderror"
                               placeholder="e.g. Senior Software Engineer">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Summary / bio</label>
                        <textarea name="summary" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('summary') border-red-500 @enderror"
                                  placeholder="Tell us about yourself, your experience, and career goals...">{{ old('summary', $user->applicantProfile->summary ?? '') }}</textarea>
                        @error('summary')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== CURRENT POSITION ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Current position</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current job title</label>
                        <input type="text" name="current_job_title" value="{{ old('current_job_title', $user->applicantProfile->current_job_title ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('current_job_title') border-red-500 @enderror"
                               placeholder="e.g. Senior Developer">
                        @error('current_job_title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current company</label>
                        <input type="text" name="current_company" value="{{ old('current_company', $user->applicantProfile->current_company ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('current_company') border-red-500 @enderror"
                               placeholder="e.g. Google">
                        @error('current_company')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== SKILLS & LANGUAGES ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Skills &amp; languages</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skills (comma separated)</label>
                        @php
                            $skills = $user->applicantProfile->skills ?? [];
                            if (is_string($skills)) {
                                $skills = json_decode($skills, true) ?? [];
                            }
                            $skillsString = is_array($skills) ? implode(', ', $skills) : '';
                        @endphp
                        <input type="text" name="skills" value="{{ old('skills', $skillsString) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('skills') border-red-500 @enderror"
                               placeholder="e.g. PHP, Laravel, React, JavaScript">
                        @error('skills')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Languages (comma separated)</label>
                        @php
                            $languages = $user->applicantProfile->languages ?? [];
                            if (is_string($languages)) {
                                $languages = json_decode($languages, true) ?? [];
                            }
                            $languagesString = is_array($languages) ? implode(', ', $languages) : '';
                        @endphp
                        <input type="text" name="languages" value="{{ old('languages', $languagesString) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('languages') border-red-500 @enderror"
                               placeholder="e.g. English, Malay, Chinese">
                        @error('languages')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Interests (comma separated)</label>
                        @php
                            $interests = $user->applicantProfile->interests ?? [];
                            if (is_string($interests)) {
                                $interests = json_decode($interests, true) ?? [];
                            }
                            $interestsString = is_array($interests) ? implode(', ', $interests) : '';
                        @endphp
                        <input type="text" name="interests" value="{{ old('interests', $interestsString) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('interests') border-red-500 @enderror"
                               placeholder="e.g. Reading, Traveling, Coding">
                        @error('interests')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== LINKS & SOCIAL MEDIA ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Links &amp; social media</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Portfolio URL</label>
                        <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $user->applicantProfile->portfolio_url ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('portfolio_url') border-red-500 @enderror"
                               placeholder="https://your-portfolio.com">
                        @error('portfolio_url')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                        <input type="url" name="github_url" value="{{ old('github_url', $user->applicantProfile->github_url ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('github_url') border-red-500 @enderror"
                               placeholder="https://github.com/username">
                        @error('github_url')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->applicantProfile->linkedin_url ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('linkedin_url') border-red-500 @enderror"
                               placeholder="https://linkedin.com/in/username">
                        @error('linkedin_url')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" value="{{ old('website', $user->applicantProfile->website ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('website') border-red-500 @enderror"
                               placeholder="https://your-website.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== RESUME ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Resume</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload resume</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="resume_path" accept=".pdf,.doc,.docx"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#1a237e] file:text-white hover:file:bg-[#131b63] @error('resume_path') border-red-500 @enderror">
                        @error('resume_path')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @if($user->applicantProfile && $user->applicantProfile->resume_path)
                        <p class="mt-2 text-sm text-gray-500">
                            Current: <a href="{{ Storage::url($user->applicantProfile->resume_path) }}" target="_blank" class="text-[#1a237e] font-medium hover:underline">{{ basename($user->applicantProfile->resume_path) }}</a>
                        </p>
                    @endif
                    <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX. Max 5MB</p>
                </div>
            </div>

            <!-- ===== JOB PREFERENCES ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Job preferences</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred work type</label>
                        <select name="preferred_work_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('preferred_work_type') border-red-500 @enderror">
                            <option value="">Select work type</option>
                            <option value="remote" {{ old('preferred_work_type', $user->applicantProfile->preferred_work_type ?? '') == 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="onsite" {{ old('preferred_work_type', $user->applicantProfile->preferred_work_type ?? '') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                            <option value="hybrid" {{ old('preferred_work_type', $user->applicantProfile->preferred_work_type ?? '') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('preferred_work_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred locations (comma separated)</label>
                        @php
                            $preferredLocations = $user->applicantProfile->preferred_locations ?? [];
                            if (is_string($preferredLocations)) {
                                $preferredLocations = json_decode($preferredLocations, true) ?? [];
                            }
                            $preferredLocationsString = is_array($preferredLocations) ? implode(', ', $preferredLocations) : '';
                        @endphp
                        <input type="text" name="preferred_locations" value="{{ old('preferred_locations', $preferredLocationsString) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('preferred_locations') border-red-500 @enderror"
                               placeholder="e.g. Kuala Lumpur, Selangor, Penang">
                        @error('preferred_locations')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== SALARY EXPECTATION ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Salary expectation</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                        <select name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('currency') border-red-500 @enderror">
                            <option value="USD" {{ old('currency', $user->applicantProfile->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="MYR" {{ old('currency', $user->applicantProfile->currency ?? 'USD') == 'MYR' ? 'selected' : '' }}>MYR</option>
                            <option value="SGD" {{ old('currency', $user->applicantProfile->currency ?? 'USD') == 'SGD' ? 'selected' : '' }}>SGD</option>
                            <option value="EUR" {{ old('currency', $user->applicantProfile->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('currency', $user->applicantProfile->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                        @error('currency')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Minimum (per month)</label>
                        <input type="number" name="salary_expectation_min" value="{{ old('salary_expectation_min', $user->applicantProfile->salary_expectation_min ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('salary_expectation_min') border-red-500 @enderror"
                               placeholder="0">
                        @error('salary_expectation_min')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maximum (per month)</label>
                        <input type="number" name="salary_expectation_max" value="{{ old('salary_expectation_max', $user->applicantProfile->salary_expectation_max ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('salary_expectation_max') border-red-500 @enderror"
                               placeholder="0">
                        @error('salary_expectation_max')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== PROFILE VISIBILITY ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Profile visibility</h3>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Make my profile visible to employers</p>
                        <p class="text-xs text-gray-400 mt-0.5">When enabled, employers can view your profile and reach out to you</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" name="is_visible" value="1"
                               {{ old('is_visible', $user->applicantProfile->is_visible ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-[#1a237e] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                    </label>
                </div>
            </div>

            <!-- ===== SUBMIT BUTTONS ===== -->
            <div class="flex items-center gap-3 pb-2">
                <button type="submit" class="px-6 py-2.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors shadow-sm">
                    Save changes
                </button>
                <a href="{{ route('candidate.profile') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-full hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>

        </div>
    </form>
</div>

<script>
    // ===== PREVIEW PROFILE PHOTO BEFORE UPLOAD =====
    document.getElementById('profile_photo')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                if (preview) {
                    preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // ===== CONFIRM BEFORE LEAVING WITH UNSAVED CHANGES =====
    let formChanged = false;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('change', function() {
            formChanged = true;
        });
        input.addEventListener('input', function() {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    form.addEventListener('submit', function() {
        formChanged = false;
    });
</script>

@endsection