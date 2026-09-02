@extends('employer.layouts.app')

@section('title', $job->title . ' - Admin Panel')
@section('page-title', 'Job Details')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $job->title }}</h2>
            <p class="text-sm text-gray-500">{{ $job->employer?->company_name ?? 'N/A' }} • {{ $job->location }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('employer.jobs.edit', $job->id) }}"
               class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                Edit Job
            </a>
            <a href="{{ route('employer.jobs.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                Back
            </a>
        </div>
    </div>

    <!-- ===== JOB INFO CARDS ===== -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Status</p>
            <span class="inline-flex items-center mt-1 px-2.5 py-1 rounded-full text-xs font-medium
                @if($job->status === 'published') bg-emerald-50 text-emerald-700
                @elseif($job->status === 'draft') bg-amber-50 text-amber-700
                @else bg-gray-50 text-gray-700
                @endif">
                {{ ucfirst($job->status) }}
            </span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Work Type</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ ucfirst($job->work_type) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Employment Type</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Applications</p>
            <p class="text-2xl font-bold text-[#1a237e] mt-1">{{ $stats['total_applications'] ?? 0 }}</p>
        </div>
    </div>

    <!-- ===== DETAILS & STATS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Description</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->description }}</p>
            </div>

            <!-- Requirements -->
            @if($job->requirements)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Requirements</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->requirements }}</p>
            </div>
            @endif

            <!-- Benefits -->
            @if($job->benefits)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Benefits</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->benefits }}</p>
            </div>
            @endif

            <!-- Skills -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $requiredSkills = is_array($job->required_skills) 
                        ? $job->required_skills 
                        : (is_string($job->required_skills) ? json_decode($job->required_skills, true) ?? [] : []);
                    
                    $preferredSkills = is_array($job->preferred_skills) 
                        ? $job->preferred_skills 
                        : (is_string($job->preferred_skills) ? json_decode($job->preferred_skills, true) ?? [] : []);
                @endphp

                @if(!empty($requiredSkills))
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Required Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($requiredSkills as $skill)
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($preferredSkills))
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Preferred Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($preferredSkills as $skill)
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs rounded-full">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- ===== APPLICATION QUESTIONS ===== -->
            @if($job->questions && $job->questions->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Application Questions
                    <span class="ml-2 text-xs text-gray-400 font-normal">({{ $job->questions->count() }} questions)</span>
                </h3>
                <div class="space-y-3">
                    @foreach($job->questions as $question)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-[#1a237e] transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-medium text-gray-900">{{ $question->question }}</span>
                                        @if($question->required)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                                Required
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                            {{ ucfirst($question->type) }}
                                        </span>
                                        @if(in_array($question->type, ['select', 'checkbox', 'radio']) && $question->options)
                                            <span class="flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                                </svg>
                                                Options: 
                                                @php
                                                    $options = is_array($question->options) 
                                                        ? $question->options 
                                                        : (is_string($question->options) ? json_decode($question->options, true) ?? [] : []);
                                                @endphp
                                                {{ implode(', ', $options) }}
                                            </span>
                                        @endif
                                        @if($question->order !== null)
                                            <span class="flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                                </svg>
                                                Order: {{ $question->order + 1 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Question Type Icon -->
                                <div class="ml-4 flex-shrink-0">
                                    @if($question->type === 'text')
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                            </svg>
                                        </span>
                                    @elseif($question->type === 'textarea')
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                            </svg>
                                        </span>
                                    @elseif($question->type === 'select')
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-600 rounded-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                            </svg>
                                        </span>
                                    @elseif($question->type === 'checkbox')
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 text-amber-600 rounded-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                        </span>
                                    @elseif($question->type === 'radio')
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-rose-100 text-rose-600 rounded-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-4">
            <!-- Quick Info -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Info</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Employer</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->employer?->company_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Recruiter</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->recruiter?->first_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Department</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->department ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Experience Level</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $job->experience_level ?? 'N/A')) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Salary</p>
                        <p class="text-sm font-medium text-gray-900">
                            @if($job->salary_min && $job->salary_max)
                                {{ $job->currency ?? 'USD' }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Visibility</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($job->visibility) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">AI Generated</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->is_ai_generated ? 'Yes' : 'No' }}</p>
                    </div>
                    @if($job->max_applications)
                    <div>
                        <p class="text-xs text-gray-400">Max Applications</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->max_applications }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Dates</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Created</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Published</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->published_at?->format('M d, Y H:i') ?? 'Not published' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Closing</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->closing_at?->format('M d, Y H:i') ?? 'No closing date' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Last Updated</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== APPLICATION STATS ===== -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Application Statistics</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div>
                <p class="text-xs text-gray-400">Total</p>
                <p class="text-lg font-bold text-gray-900">{{ $stats['total_applications'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Pending</p>
                <p class="text-lg font-bold text-amber-600">{{ $stats['pending_applications'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Shortlisted</p>
                <p class="text-lg font-bold text-blue-600">{{ $stats['shortlisted'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Interviewing</p>
                <p class="text-lg font-bold text-purple-600">{{ $stats['interviewing'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Hired</p>
                <p class="text-lg font-bold text-emerald-600">{{ $stats['hired'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Rejected</p>
                <p class="text-lg font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- ===== QUICK ACTIONS ===== -->
    <div class="flex flex-wrap items-center gap-3 pt-2">
        <a href="{{ route('employer.jobs.edit', $job->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Job
        </a>
        
        @if($job->status === 'published')
            <a href="" 
               class="inline-flex items-center px-4 py-2 bg-amber-100 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-200 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Unpublish
            </a>
        @else
            <a href="" 
               class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 text-sm font-medium rounded-lg hover:bg-emerald-200 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Publish
            </a>
        @endif
        
        <a href="" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Duplicate Job
        </a>
    </div>
</div>
@endsection