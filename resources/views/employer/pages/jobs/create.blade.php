@extends('employer.layouts.app')

@section('title', 'Create Job - Admin Panel')
@section('page-title', 'Create New Job')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
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
    <form action="{{ route('employer.jobs.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                           placeholder="e.g. Senior Software Engineer" required>
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                           placeholder="e.g. Engineering">
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Location <span class="text-red-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                           placeholder="e.g. New York, NY" required>
                </div>

                <!-- Work Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Work Type <span class="text-red-500">*</span></label>
                    <select name="work_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all" required>
                        <option value="">Select Work Type</option>
                        <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="onsite" {{ old('work_type') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                        <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <!-- Employment Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Employment Type <span class="text-red-500">*</span></label>
                    <select name="employment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all" required>
                        <option value="">Select Employment Type</option>
                        <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <!-- Experience Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Experience Level</label>
                    <select name="experience_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                        <option value="">Select Experience Level</option>
                        <option value="entry_level" {{ old('experience_level') == 'entry_level' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid_level" {{ old('experience_level') == 'mid_level' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior_level" {{ old('experience_level') == 'senior_level' ? 'selected' : '' }}>Senior Level</option>
                        <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                    </select>
                </div>

                <!-- Salary Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Min</label>
                        <input type="number" name="salary_min" value="{{ old('salary_min') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                               placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salary Max</label>
                        <input type="number" name="salary_max" value="{{ old('salary_max') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                               placeholder="100000">
                    </div>
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', 'USD') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                           placeholder="USD" maxlength="3">
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <!-- Employer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Employer <span class="text-red-500">*</span></label>
                    @php
                        $employer = \App\Models\Employer::where('user_id',Auth::id())->first();
                    @endphp
                <input type="text"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all bg-gray-50 cursor-not-allowed"
           value="{{ $employer->company_name }}"
           readonly>
    <input type="hidden"
           name="employer_id"
           value="{{ $employer->id }}">
                </div>



                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all" required>
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Visibility -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Visibility <span class="text-red-500">*</span></label>
                    <select name="visibility" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all" required>
                        <option value="public" {{ old('visibility', 'public') == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                        <option value="internal" {{ old('visibility') == 'internal' ? 'selected' : '' }}>Internal</option>
                    </select>
                </div>

                <!-- AI Generated -->
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_ai_generated" value="1" {{ old('is_ai_generated') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        <span class="text-sm text-gray-700">AI Generated Job Description</span>
                    </label>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Published Date</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Closing Date</label>
                        <input type="datetime-local" name="closing_at" value="{{ old('closing_at') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    </div>
                </div>

                <!-- Max Applications -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Max Applications</label>
                    <input type="number" name="max_applications" value="{{ old('max_applications') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                           placeholder="Unlimited" min="1">
                </div>
            </div>
        </div>

        <!-- Full Width Sections -->
        <div class="space-y-4 mt-4">
            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="6"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                          placeholder="Job description..." required>{{ old('description') }}</textarea>
            </div>

            <!-- Requirements -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Requirements</label>
                <textarea name="requirements" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                          placeholder="Job requirements...">{{ old('requirements') }}</textarea>
            </div>

            <!-- Benefits -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Benefits</label>
                <textarea name="benefits" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                          placeholder="Benefits...">{{ old('benefits') }}</textarea>
            </div>

            <!-- Required Skills -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Required Skills</label>
                <input type="text" name="required_skills" value="{{ old('required_skills') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. PHP, Laravel, React (comma separated)">
            </div>

            <!-- Preferred Skills -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Skills</label>
                <input type="text" name="preferred_skills" value="{{ old('preferred_skills') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Docker, AWS, Redis (comma separated)">
            </div>

            <!-- Education Requirement -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Education Requirement</label>
                <input type="text" name="education_requirement" value="{{ old('education_requirement') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Bachelor's in Computer Science">
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
@endsection
