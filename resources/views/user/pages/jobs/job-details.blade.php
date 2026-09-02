<!-- ============================================================ -->
<!-- JOB DETAILS PAGE · Dynamic Version                           -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        
        <!-- ===== BREADCRUMB ===== -->
        <nav class="flex items-center gap-2 text-sm mb-6" aria-label="Breadcrumb">
            <a href="{{ route('user.home') }}" class="text-slate-500 hover:text-[#1A237E] transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="javscript:;" class="text-slate-500 hover:text-[#1A237E] transition-colors">Jobs</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-[#ff7543] font-semibold">{{ $job->title }}</span>
        </nav>

        <!-- ===== MAIN CONTENT GRID ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- ===== LEFT COLUMN - Job Details ===== -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Job Header Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <!-- Company Logo -->
                            <div class="w-16 h-16 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-2xl font-bold shrink-0 overflow-hidden">
                                @if($job->employer && $job->employer->logo)
                                    <img src="{{ asset('storage/' . $job->employer->logo) }}" 
                                         alt="{{ $job->employer->company_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-bold">
                                        {{ $job->employer ? substr($job->employer->company_name, 0, 2) : 'JD' }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="text-sm text-gray-600">{{ $job->employer?->company_name ?? 'Company' }}</span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                        {{ $job->location }}
                                    </span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[#ff7543] text-xs"></i>
                                        Posted {{ $job->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active
                            </span>
                            @if($job->closing_at && $job->closing_at->diffInDays(now()) <= 7)
                                <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                    Urgent Hiring
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Job Meta Tags -->
                    <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                        @if($job->employment_type)
                            <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                            </span>
                        @endif
                        
                        @if($job->work_type)
                            <span class="text-xs font-medium 
                                @if($job->work_type === 'remote') bg-blue-50 text-blue-700
                                @elseif($job->work_type === 'hybrid') bg-orange-50 text-orange-700
                                @else bg-gray-50 text-gray-700
                                @endif px-3 py-1.5 rounded-full">
                                {{ ucfirst($job->work_type) }}
                            </span>
                        @endif
                        
                        @if($job->salary_min && $job->salary_max)
                            <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full">
                                {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                            </span>
                        @endif
                        
                        @if($job->experience_level)
                            <span class="text-xs font-medium bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $job->experience_level)) }}
                            </span>
                        @endif
                        
                        @if($job->education_requirement)
                            <span class="text-xs font-medium bg-pink-50 text-pink-700 px-3 py-1.5 rounded-full">
                                {{ $job->education_requirement }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 mt-5 pt-5 border-t border-gray-100">
                        <button class="flex-1 md:flex-none px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Apply Now
                        </button>
                        <button class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50">
                            <i class="far fa-bookmark"></i>
                            Save Job
                        </button>
                        <button class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50">
                            <i class="fas fa-share-alt"></i>
                            Share
                        </button>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-file-alt text-[#1A237E]"></i>
                        Job Description
                    </h2>
                    <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->requirements)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-list-check text-[#1A237E]"></i>
                        Requirements
                    </h2>
                    <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-gift text-[#1A237E]"></i>
                        Benefits
                    </h2>
                    <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                        {!! nl2br(e($job->benefits)) !!}
                    </div>
                </div>
                @endif

                <!-- Skills -->
                @php
                    $requiredSkills = is_array($job->required_skills) 
                        ? $job->required_skills 
                        : (is_string($job->required_skills) ? json_decode($job->required_skills, true) ?? [] : []);
                    
                    $preferredSkills = is_array($job->preferred_skills) 
                        ? $job->preferred_skills 
                        : (is_string($job->preferred_skills) ? json_decode($job->preferred_skills, true) ?? [] : []);
                @endphp

                @if(!empty($requiredSkills) || !empty($preferredSkills))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-code text-[#1A237E]"></i>
                        Skills
                    </h2>
                    
                    @if(!empty($requiredSkills))
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Required Skills:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($requiredSkills as $skill)
                                <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if(!empty($preferredSkills))
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Preferred Skills:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($preferredSkills as $skill)
                                <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full border border-purple-100">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Application Questions -->
                @if($job->questions && $job->questions->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-question-circle text-[#1A237E]"></i>
                        Application Questions
                    </h2>
                    <div class="space-y-3">
                        @foreach($job->questions as $question)
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-6 h-6 rounded-full bg-[#1A237E]/10 flex items-center justify-center text-[#1A237E] text-xs font-bold flex-shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $question->question }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-500">Type: {{ ucfirst($question->type) }}</span>
                                        @if($question->required)
                                            <span class="text-xs text-red-500">* Required</span>
                                        @endif
                                        @if($question->options)
                                            <span class="text-xs text-gray-400">
                                                Options: {{ implode(', ', is_array($question->options) ? $question->options : json_decode($question->options, true) ?? []) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Company Overview -->
                @if($job->employer)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-[#1A237E]"></i>
                        About the Company
                    </h2>
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <div class="w-20 h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-3xl font-bold shrink-0 overflow-hidden">
                            @if($job->employer->logo)
                                <img src="{{ asset('storage/' . $job->employer->logo) }}" 
                                     alt="{{ $job->employer->company_name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                {{ substr($job->employer->company_name, 0, 2) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $job->employer->company_name }}</h3>
                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">
                                <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                {{ $job->location }}
                            </p>
                            <p class="text-sm text-gray-600 mt-2 max-w-2xl">
                                @if($job->employer->description)
                                    {{ $job->employer->description }}
                                @else
                                    {{ $job->employer->company_name }} is a leading company in the {{ $job->employer->industry ?? 'industry' }} sector.
                                @endif
                            </p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                @if($job->employer->industry)
                                    <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">{{ $job->employer->industry }}</span>
                                @endif
                                @if($job->employer->website)
                                    <a href="{{ $job->employer->website }}" target="_blank" class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full hover:bg-slate-200 transition-colors">
                                        <i class="fas fa-globe mr-1"></i> Website
                                    </a>
                                @endif
                            </div>
                            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors mt-3">
                                View Company Profile
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Similar Jobs -->
                @if(isset($similarJobs) && $similarJobs->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-briefcase text-[#1A237E]"></i>
                        Similar Jobs You Might Like
                    </h2>
                    <div class="space-y-3">
                        @foreach($similarJobs as $similarJob)
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-[#1A237E]/20 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                                    {{ $similarJob->employer ? substr($similarJob->employer->company_name, 0, 2) : 'JD' }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors">
                                        <a href="{{ route('user.job.details', $similarJob->slug ?? $similarJob->id) }}">{{ $similarJob->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500">{{ $similarJob->employer?->company_name ?? 'Company' }} · {{ $similarJob->location }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-2 sm:mt-0">
                                @if($similarJob->salary_min && $similarJob->salary_max)
                                    <span class="text-xs font-medium text-gray-500">
                                        {{ $similarJob->currency ?? 'RM' }} {{ number_format($similarJob->salary_min) }}-{{ number_format($similarJob->salary_max) }}
                                    </span>
                                @endif
                                <a href="{{ route('user.job.details', $similarJob->slug ?? $similarJob->id) }}" 
                                   class="text-xs font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors">
                                    View
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- ===== RIGHT COLUMN - Sidebar ===== -->
            <div class="space-y-6">
                
                <!-- Quick Apply Card -->
                <div class="bg-gradient-to-br from-[#1A237E]/5 to-[#1A237E]/10 rounded-2xl border-2 border-[#1A237E]/20 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-3">Quick Apply</h3>
                    <p class="text-sm text-gray-600 mb-4">Apply with your profile in one click.</p>
                    <button class="w-full py-3 bg-[#1A237E] hover:bg-[#0D1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1A237E]/20 hover:shadow-xl hover:shadow-[#1A237E]/30 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Apply Now
                    </button>
                    <div class="mt-3 text-center">
                        <a href="#" class="text-xs text-[#1A237E] hover:text-[#0D1445] font-medium transition-colors">
                            <i class="far fa-file-alt mr-1"></i>
                            Upload new resume
                        </a>
                    </div>
                </div>

                <!-- Job Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-[#1A237E]"></i>
                        Job Summary
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-briefcase text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Job Type</p>
                                <p class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $job->employment_type ?? 'N/A')) }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-[#ff7543] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Location</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->location }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-money-bill-wave text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Salary</p>
                                <p class="text-sm font-medium text-gray-700">
                                    @if($job->salary_min && $job->salary_max)
                                        {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-alt text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Posted</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($job->published_at)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Published</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->published_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                        @if($job->closing_at)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-hourglass-end text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Closing Date</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->closing_at->format('M d, Y') }}</p>
                                @if($job->closing_at->diffInDays(now()) <= 7)
                                    <span class="text-xs text-amber-600">Closing soon!</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="flex items-start gap-3">
                            <i class="fas fa-users text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Experience Level</p>
                                <p class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $job->experience_level ?? 'N/A')) }}</p>
                            </div>
                        </div>
                        @if($job->education_requirement)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-graduation-cap text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Education</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->education_requirement }}</p>
                            </div>
                        </div>
                        @endif
                        @if($job->max_applications)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-users text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Max Applications</p>
                                <p class="text-sm font-medium text-gray-700">{{ $job->max_applications }}</p>
                            </div>
                        </div>
                        @endif
                        @if($job->is_ai_generated)
                        <div class="flex items-start gap-3">
                            <i class="fas fa-robot text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">AI Generated</p>
                                <p class="text-sm font-medium text-gray-700">Yes</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Share Job -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-share-alt text-[#1A237E]"></i>
                        Share This Job
                    </h3>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>

                <!-- Report Job -->
                <a href="#" class="flex items-center justify-center gap-2 text-sm text-slate-400 hover:text-[#1A237E] transition-colors p-3">
                    <i class="fas fa-flag"></i>
                    <span>Report this job</span>
                </a>
            </div>
        </div>
    </div>
</main>

@endsection