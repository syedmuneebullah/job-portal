{{-- resources/views/jobseeker/pages/employer.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', $employer->company_name . ' - Employer Details')
@section('page-title', 'Employer Details')

@section('content')

<div class="bg-slate-50/50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== BREADCRUMB ===== -->
        <nav class="flex items-center gap-2 text-sm mb-6" aria-label="Breadcrumb">
            <a href="{{ route('user.home') }}" class="text-gray-500 hover:text-[#1a237e] transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
            <a href="{{ route('candidate.employers.index') }}" class="text-gray-500 hover:text-[#1a237e] transition-colors">Employers</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-400"></i>
            <span class="text-[#ff7543] font-semibold">{{ $employer->company_name }}</span>
        </nav>

        <!-- ===== BACK BUTTON ===== -->
        <div class="mb-4">
            <a href="{{ route('candidate.employers.index') }}" 
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#1a237e] transition-colors">
                <i class="fas fa-arrow-left"></i>
                Back to Employers
            </a>
        </div>

        <!-- ===== EMPLOYER HEADER ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-start gap-6">
                <!-- Company Logo -->
                <div class="w-24 h-24 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-3xl font-bold shrink-0 overflow-hidden">
                    @if($employer->company_logo)
                        <img src="{{ Storage::url($employer->company_logo) }}" 
                             alt="{{ $employer->company_name }}" 
                             class="w-full h-full object-cover">
                    @else
                        {{ substr($employer->company_name, 0, 2) }}
                    @endif
                </div>
                
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $employer->company_name }}</h1>
                            <p class="text-sm text-gray-500">{{ $employer->industry ?? 'N/A' }}</p>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                @if($employer->location)
                                    <span class="text-sm text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt text-[#ff7543]"></i>
                                        {{ $employer->location }}
                                    </span>
                                @endif
                                @if($employer->company_size)
                                    <span class="text-sm text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-users text-[#ff7543]"></i>
                                        {{ $employer->company_size }} employees
                                    </span>
                                @endif
                                @if($employer->founded_year)
                                    <span class="text-sm text-gray-600 flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[#ff7543]"></i>
                                        Founded {{ $employer->founded_year }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            @if($employer->verification_status === 'verified')
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                            @endif
                            @if($employer->is_featured)
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star"></i>
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap items-center gap-6 mt-4 pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-xs text-gray-400">Total Jobs</p>
                            <p class="text-lg font-bold text-[#1A237E]">{{ $jobStats['total'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Active Jobs</p>
                            <p class="text-lg font-bold text-emerald-600">{{ $jobStats['active'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Rating</p>
                            <p class="text-lg font-bold text-amber-600">
                                @if($employer->rating)
                                    {{ number_format($employer->rating, 1) }}
                                    <span class="text-sm font-normal text-gray-400">/ 5.0</span>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== ABOUT COMPANY ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8 mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-[#1A237E]"></i>
                About Company
            </h2>
            @if($employer->description)
                <p class="text-sm text-gray-600 leading-relaxed">{{ $employer->description }}</p>
            @else
                <p class="text-sm text-gray-400">No description available.</p>
            @endif
            
            <!-- Contact Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-100">
                @if($employer->email)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-envelope text-[#ff7543]"></i>
                        <a href="mailto:{{ $employer->email }}" class="hover:text-[#1A237E] transition-colors">
                            {{ $employer->email }}
                        </a>
                    </div>
                @endif
                @if($employer->phone)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-phone text-[#ff7543]"></i>
                        <a href="tel:{{ $employer->phone }}" class="hover:text-[#1A237E] transition-colors">
                            {{ $employer->phone }}
                        </a>
                    </div>
                @endif
                @if($employer->website)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-globe text-[#ff7543]"></i>
                        <a href="{{ $employer->website }}" target="_blank" class="hover:text-[#1A237E] transition-colors">
                            {{ $employer->website }}
                        </a>
                    </div>
                @endif
                @if($employer->location)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-map-marker-alt text-[#ff7543]"></i>
                        {{ $employer->location }}
                    </div>
                @endif
            </div>
        </div>

        <!-- ===== JOB POSTINGS ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-briefcase text-[#1A237E]"></i>
                Open Positions ({{ $jobStats['active'] }})
            </h2>
            
            @if($jobs->count() > 0)
                <div class="space-y-3">
                    @foreach($jobs as $job)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-[#1A237E]/20 hover:shadow-md transition-all duration-300">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 hover:text-[#1A237E] transition-colors">
                                    <a href="{{ route('candidate.job.details', $job->id) }}">{{ $job->title }}</a>
                                </h4>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500 flex items-center gap-0.5">
                                        <i class="fas fa-map-marker-alt text-[#ff7543] text-[10px]"></i>
                                        {{ $job->location }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-xs text-gray-500">
                                        <i class="far fa-clock mr-1"></i>
                                        Posted {{ $job->created_at->diffForHumans() }}
                                    </span>
                                    @if($job->employment_type)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">
                                            {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                                        </span>
                                    @endif
                                    @if($job->work_type)
                                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">
                                            {{ ucfirst($job->work_type) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mt-2 sm:mt-0">
                                @if($job->salary_min && $job->salary_max)
                                    <span class="text-xs font-medium text-gray-500">
                                        {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }}-{{ number_format($job->salary_max) }}
                                    </span>
                                @endif
                                <a href="{{ route('candidate.job.details', $job->id) }}" 
                                   class="text-xs font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors">
                                    View Job
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $jobs->appends(request()->except('page'))->links() }}
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">No active jobs available at the moment.</p>
            @endif
        </div>
    </div>
</div>

@endsection