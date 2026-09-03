{{-- resources/views/jobseeker/pages/dashboard.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- ===== WELCOME CARD ===== -->
    <div class="bg-gradient-to-r from-[#1a237e] to-[#FF7543] rounded-2xl shadow-lg p-6 text-white">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ $user->first_name }}!</h2>
                <p class="text-white/80 mt-1">Here's what's happening with your job search today.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    Profile Strength: {{ $completenessPercent }}%
                </span>
                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    {{ $completenessLabel }}
                </span>
            </div>
        </div>
    </div>

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($statusCounts as $stat)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                <div class="w-8 h-8 rounded-full bg-{{ $stat['color'] }}-50 flex items-center justify-center">
                    <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-sm"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stat['count'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- ===== MAIN GRID ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ===== LEFT COLUMN (Recent Applications) ===== -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Recent Applications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-file-alt text-[#1a237e]"></i>
                        Recent Applications
                    </h3>
                    <a href="#" class="text-sm font-medium text-[#1a237e] hover:underline flex items-center gap-1">
                        View all
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($recentApplications as $application)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-briefcase text-gray-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $application->jobPost->title ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            @if($application->status === 'hired') bg-emerald-100 text-emerald-700
                            @elseif($application->status === 'shortlisted') bg-purple-100 text-purple-700
                            @elseif($application->status === 'interviewing') bg-blue-100 text-blue-700
                            @elseif($application->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                            <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">No applications yet</p>
                        <p class="text-xs text-gray-400">Start applying to jobs to see them here</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recommended Jobs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-star text-[#FF7543]"></i>
                        Recommended Jobs For You
                    </h3>
                    <a href="#" class="text-sm font-medium text-[#1a237e] hover:underline flex items-center gap-1">
                        View all
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($recommendedJobs as $job)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($job->employer && $job->employer->logo)
                                    <img src="{{ Storage::url($job->employer->logo) }}" alt="{{ $job->employer->company_name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-building text-gray-500"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $job->title }}</p>
                                <p class="text-xs text-gray-500">{{ $job->employer->company_name ?? 'N/A' }} • {{ $job->location }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-gray-500">
                                @if($job->salary_min && $job->salary_max)
                                    {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                @else
                                    Not specified
                                @endif
                            </span>
                            <a href="#" class="px-3 py-1.5 bg-[#1a237e] hover:bg-[#0d1445] text-white text-xs font-medium rounded-full transition-colors">
                                Apply
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                            <i class="fas fa-briefcase text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">No recommended jobs</p>
                        <p class="text-xs text-gray-400">Complete your profile to get personalized job recommendations</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ===== RIGHT COLUMN ===== -->
        <div class="space-y-6">

            <!-- Profile Completeness -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Profile Completeness</h3>
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold inline-block text-[#1a237e]">{{ $completenessPercent }}%</span>
                        <span class="text-xs font-semibold inline-block text-gray-500">{{ $completenessLabel }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#1a237e] to-[#FF7543] rounded-full transition-all duration-500" style="width: {{ $completenessPercent }}%"></div>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach($profileItems as $key => $completed)
                    <div class="flex items-center gap-2 text-sm">
                        @if($completed)
                            <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                        @else
                            <i class="fas fa-circle text-gray-300 text-xs"></i>
                            <span class="text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($completenessPercent < 100)
                    <a href="{{ route('candidate.profile.edit') }}" class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#1a237e] hover:bg-[#0d1445] text-white text-sm font-medium rounded-lg transition-colors">
                        Complete Your Profile
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @endif
            </div>

            <!-- Quick Tips -->
            @if(!empty($quickTips))
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border border-amber-200 p-5">
                <h3 class="text-sm font-semibold text-amber-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-lightbulb text-amber-500"></i>
                    Quick Tips
                </h3>
                <ul class="space-y-2">
                    @foreach($quickTips as $tip)
                    <li class="flex items-start gap-2 text-sm text-amber-700">
                        <i class="fas fa-chevron-right text-xs text-amber-500 mt-0.5"></i>
                        {{ $tip }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Stats Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Your Stats</h3>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Education</span>
                        <span class="font-semibold text-gray-900">{{ $educationStats['total'] }} ({{ $educationStats['ongoing'] }} ongoing)</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Experience</span>
                        <span class="font-semibold text-gray-900">{{ $experienceStats['total'] }} ({{ $experienceStats['ongoing'] }} current)</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Applications</span>
                        <span class="font-semibold text-gray-900">{{ $jobStats['total_applications'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-2">
                    <a href="#" class="flex flex-col items-center gap-1 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-search text-[#1a237e] text-lg"></i>
                        <span class="text-xs text-gray-600">Find Jobs</span>
                    </a>
                    <a href="{{ route('candidate.profile.edit') }}" class="flex flex-col items-center gap-1 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-user-edit text-[#1a237e] text-lg"></i>
                        <span class="text-xs text-gray-600">Edit Profile</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-1 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-file-upload text-[#1a237e] text-lg"></i>
                        <span class="text-xs text-gray-600">Upload Resume</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-1 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-bell text-[#1a237e] text-lg"></i>
                        <span class="text-xs text-gray-600">Job Alerts</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection