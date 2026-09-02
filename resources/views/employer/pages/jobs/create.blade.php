@extends('employer.layouts.app')

@section('title', 'Create Job - Admin Panel')
@section('page-title', 'Create New Job')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="font-medium">Please fix the following errors:</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('employer.jobs.store') }}" method="POST" class="space-y-6" id="jobForm">
        @csrf

        <!-- Widget-style Form with Sections -->
        <div class="space-y-8">
            
            <!-- Section 1: Basic Information -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Basic Information
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('title') border-red-500 @enderror"
                               placeholder="e.g. Senior Software Engineer" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('description') border-red-500 @enderror"
                                  placeholder="Job description..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                        <input type="text" name="department" value="{{ old('department') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('department') border-red-500 @enderror"
                               placeholder="e.g. Engineering">
                        @error('department')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Location <span class="text-red-500">*</span></label>
                        <input type="text" name="location" value="{{ old('location') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('location') border-red-500 @enderror"
                               placeholder="e.g. New York, NY" required>
                        @error('location')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Employment Details -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.096-1.793M21 13.255V14a2 2 0 01-2 2H5a2 2 0 01-2-2v-1.744M21 13.255V9.744A23.931 23.931 0 0012 8c-3.183 0-6.22.62-9.096 1.793M3 9.744V8m0 0l9-4 9 4m-9-4v4"/>
                        </svg>
                        Employment Details
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Work Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Work Type <span class="text-red-500">*</span></label>
                        <select name="work_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('work_type') border-red-500 @enderror" required>
                            <option value="">Select Work Type</option>
                            <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="onsite" {{ old('work_type') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                            <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('work_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employment Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Employment Type <span class="text-red-500">*</span></label>
                        <select name="employment_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('employment_type') border-red-500 @enderror" required>
                            <option value="">Select Employment Type</option>
                            <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experience Level -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Experience Level</label>
                        <select name="experience_level" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('experience_level') border-red-500 @enderror">
                            <option value="">Select Experience Level</option>
                            <option value="entry_level" {{ old('experience_level') == 'entry_level' ? 'selected' : '' }}>Entry Level</option>
                            <option value="mid_level" {{ old('experience_level') == 'mid_level' ? 'selected' : '' }}>Mid Level</option>
                            <option value="senior_level" {{ old('experience_level') == 'senior_level' ? 'selected' : '' }}>Senior Level</option>
                            <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                        </select>
                        @error('experience_level')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Employer <span class="text-red-500">*</span></label>
                        @php
                            $employer = \App\Models\Employer::where('user_id', Auth::id())->first();
                        @endphp
                        <input type="text"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed"
                               value="{{ $employer->company_name ?? 'N/A' }}"
                               readonly>
                        <input type="hidden" name="employer_id" value="{{ $employer->id ?? '' }}">
                        @error('employer_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Compensation -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Compensation
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Salary Min -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Min</label>
                        <input type="number" name="salary_min" value="{{ old('salary_min') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('salary_min') border-red-500 @enderror"
                               placeholder="0">
                        @error('salary_min')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary Max -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Max</label>
                        <input type="number" name="salary_max" value="{{ old('salary_max') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('salary_max') border-red-500 @enderror"
                               placeholder="100000">
                        @error('salary_max')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', 'USD') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('currency') border-red-500 @enderror"
                               placeholder="USD" maxlength="3">
                        @error('currency')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Requirements & Skills -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Requirements & Skills
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Requirements -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Requirements</label>
                        <textarea name="requirements" rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('requirements') border-red-500 @enderror"
                                  placeholder="Job requirements...">{{ old('requirements') }}</textarea>
                        @error('requirements')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Required Skills -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Required Skills</label>
                        <input type="text" name="required_skills" value="{{ old('required_skills') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('required_skills') border-red-500 @enderror"
                               placeholder="e.g. PHP, Laravel, React (comma separated)">
                        @error('required_skills')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preferred Skills -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Skills</label>
                        <input type="text" name="preferred_skills" value="{{ old('preferred_skills') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('preferred_skills') border-red-500 @enderror"
                               placeholder="e.g. Docker, AWS, Redis (comma separated)">
                        @error('preferred_skills')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Benefits -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Benefits</label>
                        <textarea name="benefits" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('benefits') border-red-500 @enderror"
                                  placeholder="Benefits...">{{ old('benefits') }}</textarea>
                        @error('benefits')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Education Requirement -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Education Requirement</label>
                        <input type="text" name="education_requirement" value="{{ old('education_requirement') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('education_requirement') border-red-500 @enderror"
                               placeholder="e.g. Bachelor's in Computer Science">
                        @error('education_requirement')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 5: Publishing & Visibility -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Publishing & Visibility
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('status') border-red-500 @enderror" required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visibility -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Visibility <span class="text-red-500">*</span></label>
                        <select name="visibility" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('visibility') border-red-500 @enderror" required>
                            <option value="public" {{ old('visibility', 'public') == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="internal" {{ old('visibility') == 'internal' ? 'selected' : '' }}>Internal</option>
                        </select>
                        @error('visibility')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Published Date</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Closing Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Closing Date</label>
                        <input type="datetime-local" name="closing_at" value="{{ old('closing_at') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('closing_at') border-red-500 @enderror">
                        @error('closing_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Applications -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Max Applications</label>
                        <input type="number" name="max_applications" value="{{ old('max_applications') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('max_applications') border-red-500 @enderror"
                               placeholder="Unlimited" min="1">
                        @error('max_applications')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- AI Generated -->
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_ai_generated" value="1" {{ old('is_ai_generated') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e] w-5 h-5">
                            <span class="text-sm text-gray-700">AI Generated Job Description</span>
                        </label>
                        @error('is_ai_generated')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 6: Application Questions -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Application Questions
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Add custom questions for applicants to answer when applying.</p>
                </div>
                <div class="p-6">
                    <div id="questions-container" class="space-y-4">
                        @if(old('questions') && count(old('questions')) > 0)
                            @foreach(old('questions') as $index => $question)
                                <div class="question-item bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="text-sm font-medium text-gray-700">Question #{{ $loop->iteration }}</h4>
                                        <button type="button" class="remove-question text-red-500 hover:text-red-700 text-sm font-medium">
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-4">
                                        <input type="hidden" name="questions[{{ $index }}][order]" value="{{ $question['order'] ?? $index }}">
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Question <span class="text-red-500">*</span></label>
                                            <input type="text" name="questions[{{ $index }}][question]" 
                                                   value="{{ $question['question'] ?? '' }}"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('questions.'.$index.'.question') border-red-500 @enderror"
                                                   placeholder="e.g. Why do you want to work here?">
                                            @error('questions.'.$index.'.question')
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Question Type <span class="text-red-500">*</span></label>
                                                <select name="questions[{{ $index }}][type]" 
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all question-type @error('questions.'.$index.'.type') border-red-500 @enderror">
                                                    <option value="text" {{ ($question['type'] ?? '') == 'text' ? 'selected' : '' }}>Short Text</option>
                                                    <option value="textarea" {{ ($question['type'] ?? '') == 'textarea' ? 'selected' : '' }}>Long Text</option>
                                                    <option value="select" {{ ($question['type'] ?? '') == 'select' ? 'selected' : '' }}>Dropdown</option>
                                                    <option value="checkbox" {{ ($question['type'] ?? '') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                    <option value="radio" {{ ($question['type'] ?? '') == 'radio' ? 'selected' : '' }}>Radio</option>
                                                </select>
                                                @error('questions.'.$index.'.type')
                                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Required</label>
                                                <select name="questions[{{ $index }}][required]" 
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                                                    <option value="0" {{ ($question['required'] ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                                    <option value="1" {{ ($question['required'] ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="question-options-wrapper {{ in_array($question['type'] ?? '', ['select', 'checkbox', 'radio']) ? '' : 'hidden' }}">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Options (comma separated)</label>
                                            <input type="text" name="questions[{{ $index }}][options]" 
                                                   value="{{ isset($question['options']) ? (is_array($question['options']) ? implode(', ', $question['options']) : $question['options']) : '' }}"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                                                   placeholder="e.g. Option 1, Option 2, Option 3">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="empty-questions-state" class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No questions added yet</p>
                                <p class="text-sm text-gray-400 mt-1">Click the button below to add custom questions for applicants</p>
                            </div>
                        @endif
                    </div>
                    
                    <button type="button" id="add-question" class="mt-4 inline-flex items-center px-4 py-2 bg-[#1a237e] text-white rounded-lg hover:bg-[#0d1445] transition text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Question
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                Create Job
            </button>
            <a href="{{ route('employer.jobs.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Hidden template for new questions -->
<template id="question-template">
    <div class="question-item bg-gray-50 rounded-lg p-4 border border-gray-200">
        <div class="flex justify-between items-start mb-3">
            <h4 class="text-sm font-medium text-gray-700">New Question</h4>
            <button type="button" class="remove-question text-red-500 hover:text-red-700 text-sm font-medium">
                Remove
            </button>
        </div>
        
        <div class="grid grid-cols-1 gap-4">
            <input type="hidden" name="questions[__INDEX__][order]" value="__INDEX__">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Question <span class="text-red-500">*</span></label>
                <input type="text" name="questions[__INDEX__][question]" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Why do you want to work here?">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Question Type <span class="text-red-500">*</span></label>
                    <select name="questions[__INDEX__][type]" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all question-type">
                        <option value="text">Short Text</option>
                        <option value="textarea">Long Text</option>
                        <option value="select">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Required</label>
                    <select name="questions[__INDEX__][required]" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
            
            <div class="question-options-wrapper hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Options (comma separated)</label>
                <input type="text" name="questions[__INDEX__][options]" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Option 1, Option 2, Option 3">
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize question counter
    let questionCounter = {{ count(old('questions', [])) }};
    const container = document.getElementById('questions-container');
    const template = document.getElementById('question-template');
    
    // Function to update question numbers
    function updateQuestionNumbers() {
        const items = container.querySelectorAll('.question-item');
        items.forEach(function(item, index) {
            const heading = item.querySelector('h4');
            if (heading) {
                heading.textContent = 'Question #' + (index + 1);
            }
        });
    }
    
    // Add question
    document.getElementById('add-question').addEventListener('click', function() {
        // Remove empty state if it exists
        const emptyStateEl = container.querySelector('#empty-questions-state');
        if (emptyStateEl) {
            emptyStateEl.remove();
        }
        
        // Clone template and replace index
        const newHtml = template.innerHTML.replace(/__INDEX__/g, questionCounter);
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newHtml;
        const questionItem = tempDiv.firstElementChild;
        
        // Append to container
        container.appendChild(questionItem);
        
        // Attach remove listener
        const removeBtn = questionItem.querySelector('.remove-question');
        removeBtn.addEventListener('click', function() {
            questionItem.remove();
            updateQuestionNumbers();
            
            // If no questions left, show empty state
            if (container.querySelectorAll('.question-item').length === 0) {
                container.innerHTML = `
                    <div id="empty-questions-state" class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">No questions added yet</p>
                        <p class="text-sm text-gray-400 mt-1">Click the button below to add custom questions for applicants</p>
                    </div>
                `;
            }
        });
        
        // Attach type change listener to show/hide options
        const typeSelect = questionItem.querySelector('.question-type');
        const optionsWrapper = questionItem.querySelector('.question-options-wrapper');
        
        typeSelect.addEventListener('change', function() {
            if (['select', 'checkbox', 'radio'].includes(this.value)) {
                optionsWrapper.classList.remove('hidden');
            } else {
                optionsWrapper.classList.add('hidden');
            }
        });
        
        // Update question numbers
        updateQuestionNumbers();
        
        // Increment counter
        questionCounter++;
    });
    
    // Attach listeners to existing questions
    document.querySelectorAll('.question-item').forEach(function(item) {
        // Remove listener
        const removeBtn = item.querySelector('.remove-question');
        removeBtn.addEventListener('click', function() {
            item.remove();
            updateQuestionNumbers();
            
            if (container.querySelectorAll('.question-item').length === 0) {
                container.innerHTML = `
                    <div id="empty-questions-state" class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">No questions added yet</p>
                        <p class="text-sm text-gray-400 mt-1">Click the button below to add custom questions for applicants</p>
                    </div>
                `;
            }
        });
        
        // Type change listener
        const typeSelect = item.querySelector('.question-type');
        const optionsWrapper = item.querySelector('.question-options-wrapper');
        
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                if (['select', 'checkbox', 'radio'].includes(this.value)) {
                    optionsWrapper.classList.remove('hidden');
                } else {
                    optionsWrapper.classList.add('hidden');
                }
            });
            
            // Initialize visibility on page load
            if (['select', 'checkbox', 'radio'].includes(typeSelect.value)) {
                optionsWrapper.classList.remove('hidden');
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.question-item {
    transition: all 0.2s ease;
}
.question-item:hover {
    border-color: #1a237e;
}
.question-item:first-child {
    margin-top: 0;
}
</style>
@endpush

@endsection