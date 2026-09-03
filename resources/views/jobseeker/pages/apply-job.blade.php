{{-- resources/views/jobseeker/pages/apply-job.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Apply for ' . $job->title)
@section('page-title', 'Apply for Job')

@section('content')

<div class="bg-slate-50/50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="mb-6">
            <a href="{{ route('candidate.jobs.listings') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#1a237e] transition-colors mb-4">
                <i class="fas fa-arrow-left"></i>
                Back to Jobs
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Apply for <span class="text-[#ff7543]">{{ $job->title }}</span></h1>
            <p class="text-sm text-gray-500 mt-1">{{ $job->employer?->company_name ?? 'Company' }} • {{ $job->location }}</p>
        </div>

        <!-- ===== JOB SUMMARY CARD ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6 mb-6">
            <div class="flex flex-wrap items-start gap-4">
                <div class="w-14 h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0 overflow-hidden">
                    @if($job->employer && $job->employer->company_logo)
                        <img src="{{ Storage::url($job->employer->company_logo) }}" 
                             alt="{{ $job->employer->company_name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-lg font-bold">
                            {{ $job->employer ? substr($job->employer->company_name, 0, 2) : 'JD' }}
                        </span>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $job->employer?->company_name ?? 'Company' }}</p>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <span class="text-sm text-gray-500 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                            {{ $job->location }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span class="text-sm text-gray-500">
                            <i class="far fa-clock text-[#ff7543] text-xs mr-1"></i>
                            Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                        @if($job->employment_type)
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                            </span>
                        @endif
                        @if($job->work_type)
                            <span class="text-xs font-medium 
                                @if($job->work_type === 'remote') bg-blue-50 text-blue-700
                                @elseif($job->work_type === 'hybrid') bg-orange-50 text-orange-700
                                @else bg-gray-50 text-gray-700
                                @endif px-2.5 py-1 rounded-full">
                                {{ ucfirst($job->work_type) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm font-medium text-gray-700">Application Deadline</span>
                    <p class="text-sm font-semibold text-amber-600">
                        @if($job->closing_at)
                            {{ $job->closing_at->format('M d, Y') }}
                            @if($job->closing_at->diffInDays(now()) <= 7)
                                <span class="text-xs text-red-500 block">(Closing soon!)</span>
                            @endif
                        @else
                            Not specified
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- ===== APPLICATION FORM ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-8">
            <form action="{{ route('candidate.job.apply') }}" method="POST" enctype="multipart/form-data" id="applyForm">
                @csrf
                <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                
                <!-- ===== PROFILE INFORMATION ===== -->
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-[#1A237E]"></i>
                        Profile Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" value="{{ $user->full_name }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" value="{{ $user->email }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" value="{{ $user->phone ?? 'Not provided' }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" value="{{ $user->location ?? 'Not provided' }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 cursor-not-allowed">
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <a href="{{ route('candidate.profile.edit') }}" class="text-sm text-[#1a237e] hover:underline">
                            <i class="fas fa-edit"></i> Update Profile
                        </a>
                    </div>
                </div>

                <!-- ===== RESUME / CV ===== -->
<div class="mb-6 pb-6 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-file-alt text-[#1A237E]"></i>
        Resume / CV
    </h3>
    
    @if($applicantProfile && $applicantProfile->resume_path)
        <div class="flex items-center gap-3 p-3 bg-emerald-50 border border-emerald-200 rounded-lg mb-3">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-700">Current Resume</p>
                <a href="{{ Storage::url($applicantProfile->resume_path) }}" target="_blank" 
                   class="text-sm text-[#1a237e] hover:underline flex items-center gap-1">
                    <i class="fas fa-file-pdf"></i>
                    {{ basename($applicantProfile->resume_path) }}
                </a>
            </div>
            <label class="px-3 py-1.5 bg-[#1a237e] hover:bg-[#0d1445] text-white text-sm rounded-lg cursor-pointer transition-colors">
                Change
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="hidden">
            </label>
        </div>
    @else
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#ff7543] transition-colors" id="resumeDropZone">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <p class="text-sm text-gray-600">Upload your resume (PDF, DOC, DOCX)</p>
            <p class="text-xs text-gray-400 mt-1">Max file size: 5MB</p>
            <label class="mt-3 inline-block px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-lg cursor-pointer transition-colors">
                Choose File
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="hidden" id="resumeInput">
            </label>
            <div id="resumeFileName" class="mt-2 text-sm text-emerald-600 hidden">
                <i class="fas fa-check-circle"></i> <span id="resumeFileNameText"></span>
            </div>
        </div>
    @endif
    
    @error('resume')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
    
    <!-- Hidden validation message for resume -->
    @if(!$applicantProfile || !$applicantProfile->resume_path)
        <p id="resumeError" class="mt-1 text-sm text-red-500 hidden">Please upload your resume to apply for this position.</p>
    @endif
    
    <p class="text-xs text-gray-400 mt-2">
        <i class="fas fa-info-circle"></i> 
        @if($applicantProfile && $applicantProfile->resume_path)
            Upload a new resume to replace the current one.
        @else
            Please upload your resume to apply for this position.
        @endif
    </p>
</div>

                <!-- ===== COVER LETTER ===== -->
                <div class="mb-6 pb-6 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-envelope text-[#1A237E]"></i>
                        Cover Letter
                    </h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Why are you a good fit for this role?</label>
                        <textarea name="cover_letter" rows="6"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff7543] focus:border-transparent outline-none transition-all @error('cover_letter') border-red-500 @enderror"
                                  placeholder="Write your cover letter here...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-info-circle"></i> 
                            Maximum 5000 characters. Tell us why you're interested and what makes you the right candidate.
                        </p>
                    </div>
                </div>

                <!-- ===== APPLICATION QUESTIONS ===== -->
                @if($job->questions && $job->questions->count() > 0)
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-question-circle text-[#1A237E]"></i>
                            Application Questions
                        </h3>
                        <div class="space-y-4">
                            @foreach($job->questions as $index => $question)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $question->question }}
                                        @if($question->required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    @if($question->type === 'text')
                                        <input type="text" name="answers[{{ $index }}]" 
                                               value="{{ old('answers.'.$index) }}"
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff7543] focus:border-transparent outline-none transition-all @error('answers.'.$index) border-red-500 @enderror"
                                               placeholder="Your answer..."
                                               {{ $question->required ? 'required' : '' }}>
                                    @elseif($question->type === 'textarea')
                                        <textarea name="answers[{{ $index }}]" rows="3"
                                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff7543] focus:border-transparent outline-none transition-all @error('answers.'.$index) border-red-500 @enderror"
                                                  placeholder="Your answer..."
                                                  {{ $question->required ? 'required' : '' }}>{{ old('answers.'.$index) }}</textarea>
                                    @elseif($question->type === 'select')
                                        <select name="answers[{{ $index }}]" 
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff7543] focus:border-transparent outline-none transition-all @error('answers.'.$index) border-red-500 @enderror"
                                                {{ $question->required ? 'required' : '' }}>
                                            <option value="">Select an option</option>
                                            @php
                                                $options = is_array($question->options) 
                                                    ? $question->options 
                                                    : (is_string($question->options) ? json_decode($question->options, true) ?? [] : []);
                                            @endphp
                                            @foreach($options as $option)
                                                <option value="{{ $option }}" {{ old('answers.'.$index) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @elseif($question->type === 'checkbox')
                                        <div class="space-y-2">
                                            @php
                                                $options = is_array($question->options) 
                                                    ? $question->options 
                                                    : (is_string($question->options) ? json_decode($question->options, true) ?? [] : []);
                                                $oldValues = old('answers.'.$index, []);
                                            @endphp
                                            @foreach($options as $option)
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" name="answers[{{ $index }}][]" value="{{ $option }}"
                                                           class="rounded border-gray-300 text-[#ff7543] focus:ring-[#ff7543]"
                                                           {{ in_array($option, (array)$oldValues) ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-700">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'radio')
                                        <div class="space-y-2">
                                            @php
                                                $options = is_array($question->options) 
                                                    ? $question->options 
                                                    : (is_string($question->options) ? json_decode($question->options, true) ?? [] : []);
                                            @endphp
                                            @foreach($options as $option)
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}"
                                                           class="border-gray-300 text-[#ff7543] focus:ring-[#ff7543]"
                                                           {{ old('answers.'.$index) == $option ? 'checked' : '' }}
                                                           {{ $question->required ? 'required' : '' }}>
                                                    <span class="text-sm text-gray-700">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                    @error('answers.'.$index)
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ===== TERMS & CONDITIONS ===== -->
                <div class="mb-6">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="terms" name="terms" value="1" required
                               class="mt-1 w-4 h-4 rounded border-gray-300 text-[#ff7543] focus:ring-[#ff7543]"
                               {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms" class="text-sm text-gray-600">
                            I confirm that all information provided is accurate and complete. 
                            I understand that providing false information may result in my application being rejected.
                            <span class="text-red-500">*</span>
                        </label>
                    </div>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ===== SUBMIT BUTTONS ===== -->
                <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" id="submitBtn" 
                            class="px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane"></i>
                        <span id="submitText">Submit Application</span>
                        <span id="submitSpinner" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    <a href="{{ route('candidate.jobs.listings') }}" 
                       class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('applyForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        
        form.addEventListener('submit', function(e) {
            // Disable button and show spinner
            submitBtn.disabled = true;
            submitText.textContent = 'Submitting...';
            submitSpinner.classList.remove('hidden');
        });

        // File input preview
        const fileInput = document.querySelector('input[name="resume"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    const label = this.closest('label');
                    if (label) {
                        label.innerHTML = fileName + ' ✓';
                        label.classList.add('bg-emerald-600');
                        label.classList.remove('bg-[#ff7543]');
                    }
                }
            });
        }
    });
</script>

@push('styles')
<style>
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
    }
    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .file-input-wrapper:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@endsection