{{-- resources/views/jobseeker/pages/profile.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@push('styles')
<style>
    /* Modal styles */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-content {
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
@php
    $latestExperience = $user->experiences->first();
    $completenessItems = [
        (bool) $user->profile_photo,
        (bool) $user->phone,
        $user->educations->count() > 0,
        $user->experiences->count() > 0,
        $user->certificates->count() > 0,
        (bool) ($user->applicantProfile && $user->applicantProfile->summary),
        (bool) ($user->applicantProfile && !empty($user->applicantProfile->skills)),
    ];
    $completenessScore = count(array_filter($completenessItems));
    $completenessPercent = (int) round(($completenessScore / count($completenessItems)) * 100);
    $completenessLabel = $completenessPercent >= 100 ? 'All-Star' : ($completenessPercent >= 60 ? 'Intermediate' : 'Beginner');
@endphp

<div class="space-y-4">

    <!-- ===== INTRO CARD (LinkedIn-style header) ===== -->
    <div class="relative bg-white rounded-lg border border-gray-200 overflow-visible">
        <!-- Cover banner -->
        <div class="relative h-32 sm:h-40  overflow-hidden rounded-t-lg">
    <div class="absolute inset-0"
         style="background-image: url('{{ asset('user-assets/background/Hero11.jpg') }}'); background-size: cover; background-position: center;"></div>
    
</div>

        <!-- Edit profile (pencil) -->
        <a href="{{ route('candidate.profile.edit') }}" aria-label="Edit profile"
                class="absolute top-36 sm:top-44 right-4 w-9 h-9 rounded-full bg-white border border-gray-300 hover:bg-gray-50 flex items-center justify-center shadow-sm transition-colors">
            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </a>

        <div class="px-4 sm:px-6 pb-6">
            <!-- Avatar -->
            <div class="-mt-14 sm:-mt-16 mb-3">
                <div class="relative inline-block">
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white bg-white shadow-sm overflow-hidden">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}"
                                 alt="{{ $user->full_name }}"
                                 class="w-40 object-cover">
                        @else
                            <div class="w-full h-full bg-[#1a237e] flex items-center justify-center">
                                <span class="text-3xl font-bold text-white">{{ $user->initials }}</span>
                            </div>
                        @endif
                    </div>
                    
                    
                </div>
            </div>

            <!-- Name + headline -->
            <div class="flex items-center gap-1.5 flex-wrap">
                <h2 class="text-2xl sm:text-[26px] font-bold text-gray-900 leading-tight">{{ $user->full_name }}</h2>
                @if($user->email_verified_at)
                    <span class="inline-flex items-center justify-center w-[18px] h-[18px] rounded-full bg-[#1a237e]" title="Verified">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                @endif
            </div>

            <p class="text-[15px] text-gray-700 mt-0.5">
                @if($user->applicantProfile && $user->applicantProfile->title)
                    {{ $user->applicantProfile->title }}
                @elseif($latestExperience)
                    {{ $latestExperience->job_title ?? 'Job Seeker' }}@if($latestExperience->company_name) at {{ $latestExperience->company_name }}@endif
                @else
                    {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}
                @endif
            </p>

            <!-- Location -->
            @if($user->applicantProfile && $user->applicantProfile->preferred_locations)
                @php
                    $locations = is_array($user->applicantProfile->preferred_locations) 
                        ? $user->applicantProfile->preferred_locations 
                        : json_decode($user->applicantProfile->preferred_locations, true) ?? [];
                @endphp
                @if(!empty($locations))
                    <p class="text-sm text-gray-500 mt-1">
                        <svg class="w-3.5 h-3.5 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ implode(', ', $locations) }}
                    </p>
                @endif
            @endif

            <p class="text-sm text-gray-500 mt-2">
                Joined {{ $user->created_at->format('M d, Y') }} ({{ $user->created_at->diffForHumans() }}) &middot;
                <a href="#" class="font-semibold text-[#1a237e] hover:underline">Contact info</a>
            </p>

            <!-- Status / type pills -->
            <div class="flex flex-wrap items-center gap-2 mt-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                    @if($user->user_type === 'admin') bg-purple-50 text-purple-700
                    @elseif($user->user_type === 'employer') bg-orange-50 text-orange-700
                    @elseif($user->user_type === 'recruiter') bg-blue-50 text-blue-700
                    @else bg-emerald-50 text-emerald-700
                    @endif">
                    <span class="w-1.5 h-1.5 rounded-full
                        @if($user->user_type === 'admin') bg-purple-500
                        @elseif($user->user_type === 'employer') bg-orange-500
                        @elseif($user->user_type === 'recruiter') bg-blue-500
                        @else bg-emerald-500
                        @endif"></span>
                    {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                    @if($user->status === 'active') bg-emerald-50 text-emerald-700
                    @elseif($user->status === 'pending') bg-amber-50 text-amber-700
                    @elseif($user->status === 'suspended') bg-red-50 text-red-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst($user->status) }}
                </span>
                @if($user->phone)
                    <span class="text-xs text-gray-500">{{ $user->phone }}</span>
                @endif
            </div>

            <!-- Action pills -->
            <div class="flex flex-wrap items-center gap-2 mt-4">
                @if(!$user->email_verified_at)
                    <a href="#" class="inline-flex items-center gap-2 px-5 py-1.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors">
                        Verify email
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 px-5 py-1.5 border border-[#1a237e] text-[#1a237e] hover:bg-[#1a237e]/5 text-sm font-semibold rounded-full transition-colors">
                        View activity
                    </a>
                @else
                    <a href="{{route('candidate.cv.builder')}}" class="inline-flex items-center gap-2 px-5 py-1.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors">
                        Generate Professional CV
                    </a>
                @endif
                <a href="#" class="inline-flex items-center gap-2 px-5 py-1.5 border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-semibold rounded-full transition-colors">
                    Reset password
                </a>
            </div>
        </div>
    </div>

    <!-- ===== MAIN GRID: content + sidebar ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">

        <!-- ============ MAIN COLUMN ============ -->
        <div class="lg:col-span-2 space-y-4">

            <!-- ===== ABOUT / SUMMARY ===== -->
            @if($user->applicantProfile && $user->applicantProfile->summary)
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-2">About</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $user->applicantProfile->summary }}</p>
            </div>
            @endif

            <!-- ===== CURRENT POSITION ===== -->
            @if($user->applicantProfile && ($user->applicantProfile->current_job_title || $user->applicantProfile->current_company))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-2">Current Position</h3>
                <p class="text-sm text-gray-600">
                    {{ $user->applicantProfile->current_job_title ?? 'Position' }}
                    @if($user->applicantProfile->current_company)
                        at <span class="font-medium">{{ $user->applicantProfile->current_company }}</span>
                    @endif
                </p>
            </div>
            @endif

            <!-- Analytics strip -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-5 pt-4 pb-1">
                    <h3 class="text-base font-semibold text-gray-900">Profile overview</h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y divide-gray-200 border-t border-gray-200">
                    @php
                        $overviewItems = [
                            ['label' => 'Total jobs', 'value' => $stats['total_jobs'] ?? 0, 'color' => 'indigo'],
                            ['label' => 'Active jobs', 'value' => $stats['active_jobs'] ?? 0, 'color' => 'emerald'],
                            ['label' => 'Applications', 'value' => $stats['total_applications'] ?? 0, 'color' => 'blue'],
                            ['label' => 'Pending', 'value' => $stats['pending_applications'] ?? 0, 'color' => 'amber'],
                            ['label' => 'Shortlisted', 'value' => $stats['shortlisted_applications'] ?? 0, 'color' => 'purple'],
                            ['label' => 'Hired', 'value' => $stats['hired_applications'] ?? 0, 'color' => 'emerald'],
                            ['label' => 'Rejected', 'value' => $stats['rejected_applications'] ?? 0, 'color' => 'red'],
                            ['label' => 'Member since', 'value' => $user->created_at->format('M Y'), 'color' => 'gray'],
                        ];
                    @endphp
                    @foreach($overviewItems as $item)
                        <div class="flex items-start gap-3 p-4 hover:bg-gray-50 transition-colors">
                            <span class="w-2 h-2 mt-1.5 rounded-full shrink-0
                                @if($item['color'] === 'indigo') bg-indigo-500
                                @elseif($item['color'] === 'emerald') bg-emerald-500
                                @elseif($item['color'] === 'blue') bg-blue-500
                                @elseif($item['color'] === 'amber') bg-amber-500
                                @elseif($item['color'] === 'purple') bg-purple-500
                                @elseif($item['color'] === 'red') bg-red-500
                                @else bg-gray-400
                                @endif"></span>
                            <div class="min-w-0">
                                <p class="text-lg font-bold text-gray-900 leading-none">{{ $item['value'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item['label'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ===== SKILLS ===== -->
            @php
                $skills = [];
                if ($user->applicantProfile && $user->applicantProfile->skills) {
                    $skills = is_array($user->applicantProfile->skills) 
                        ? $user->applicantProfile->skills 
                        : json_decode($user->applicantProfile->skills, true) ?? [];
                }
            @endphp

            @if(!empty($skills))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-3">Skills</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        <span class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-full transition-colors cursor-pointer">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ===== LANGUAGES ===== -->
            @php
                $languages = [];
                if ($user->applicantProfile && $user->applicantProfile->languages) {
                    $languages = is_array($user->applicantProfile->languages) 
                        ? $user->applicantProfile->languages 
                        : json_decode($user->applicantProfile->languages, true) ?? [];
                }
            @endphp

            @if(!empty($languages))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-3">Languages</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($languages as $language)
                        <span class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-full transition-colors cursor-pointer">
                            {{ $language }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ===== INTERESTS ===== -->
            @php
                $interests = [];
                if ($user->applicantProfile && $user->applicantProfile->interests) {
                    $interests = is_array($user->applicantProfile->interests) 
                        ? $user->applicantProfile->interests 
                        : json_decode($user->applicantProfile->interests, true) ?? [];
                }
            @endphp

            @if(!empty($interests))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-3">Interests</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($interests as $interest)
                        <span class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-sm font-medium rounded-full transition-colors cursor-pointer">
                            {{ $interest }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ===== LINKS / SOCIAL ===== -->
            @if($user->applicantProfile && ($user->applicantProfile->portfolio_url || $user->applicantProfile->github_url || $user->applicantProfile->linkedin_url || $user->applicantProfile->website))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Links
                </h3>
                <div class="space-y-2">
                    @if($user->applicantProfile->portfolio_url)
                    <a href="{{ $user->applicantProfile->portfolio_url }}" target="_blank" class="flex items-center gap-3 text-sm text-[#1a237e] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Portfolio
                    </a>
                    @endif
                    
                    @if($user->applicantProfile->github_url)
                    <a href="{{ $user->applicantProfile->github_url }}" target="_blank" class="flex items-center gap-3 text-sm text-[#1a237e] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        GitHub
                    </a>
                    @endif
                    
                    @if($user->applicantProfile->linkedin_url)
                    <a href="{{ $user->applicantProfile->linkedin_url }}" target="_blank" class="flex items-center gap-3 text-sm text-[#1a237e] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        LinkedIn
                    </a>
                    @endif
                    
                    @if($user->applicantProfile->website)
                    <a href="{{ $user->applicantProfile->website }}" target="_blank" class="flex items-center gap-3 text-sm text-[#1a237e] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                        </svg>
                        Website
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- ===== PREFERRED WORK TYPE ===== -->
            @if($user->applicantProfile && $user->applicantProfile->preferred_work_type)
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Preferred Work Type
                </h3>
                <p class="text-sm text-gray-600">{{ ucfirst($user->applicantProfile->preferred_work_type) }}</p>
            </div>
            @endif

            <!-- ===== SALARY EXPECTATION ===== -->
            @if($user->applicantProfile && ($user->applicantProfile->salary_expectation_min || $user->applicantProfile->salary_expectation_max))
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Salary Expectation
                </h3>
                <p class="text-sm text-gray-600">
                    @if($user->applicantProfile->salary_expectation_min && $user->applicantProfile->salary_expectation_max)
                        {{ $user->applicantProfile->currency ?? 'USD' }} 
                        {{ number_format($user->applicantProfile->salary_expectation_min) }} - 
                        {{ number_format($user->applicantProfile->salary_expectation_max) }}
                    @elseif($user->applicantProfile->salary_expectation_min)
                        {{ $user->applicantProfile->currency ?? 'USD' }} 
                        {{ number_format($user->applicantProfile->salary_expectation_min) }}+
                    @elseif($user->applicantProfile->salary_expectation_max)
                        Up to {{ $user->applicantProfile->currency ?? 'USD' }} 
                        {{ number_format($user->applicantProfile->salary_expectation_max) }}
                    @endif
                </p>
            </div>
            @endif

            <!-- ===== EXPERIENCE SECTION ===== -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Experience</h3>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="openModal('experienceModal', null)" 
                                class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                            <svg class="w-4.5 h-4.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-5 pb-5" id="experienceList">
                    @forelse($user->experiences as $experience)
                        <div class="relative flex gap-4 {{ !$loop->last ? 'pb-6' : '' }} experience-item" data-id="{{ $experience->id }}">
                            @if(!$loop->last)
                                <span class="absolute left-6 top-14 bottom-0 w-px bg-gray-200"></span>
                            @endif
                            <div class="relative z-10 w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <div class="flex items-start justify-between gap-2 flex-wrap">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-[15px]">{{ $experience->job_title ?? 'Position' }}</p>
                                        <p class="text-sm text-gray-600">{{ $experience->company_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $experience->period }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        @if($experience->is_ongoing)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                                Current
                                            </span>
                                        @endif
                                        <button onclick="openModal('experienceModal', {{ $experience->id }})" 
                                                class="p-1 text-gray-400 hover:text-[#1a237e] hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteItem('experience', {{ $experience->id }})" 
                                                class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8" id="emptyExperience">
                            <div class="w-14 h-14 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">No experience added yet</p>
                            <p class="text-xs text-gray-400">Add your work experience to strengthen your profile</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ===== EDUCATION SECTION ===== -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Education</h3>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="openModal('educationModal', null)" 
                                class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                            <svg class="w-4.5 h-4.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-5 pb-5" id="educationList">
                    @forelse($user->educations as $education)
                        <div class="relative flex gap-4 {{ !$loop->last ? 'pb-6' : '' }} education-item" data-id="{{ $education->id }}">
                            @if(!$loop->last)
                                <span class="absolute left-6 top-14 bottom-0 w-px bg-gray-200"></span>
                            @endif
                            <div class="relative z-10 w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                <i class="fas fa-graduation-cap text-gray-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <div class="flex items-start justify-between gap-2 flex-wrap">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-[15px]">{{ $education->education_title ?? 'Education' }}</p>
                                        <p class="text-sm text-gray-600">{{ $education->institute_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $education->period }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        @if($education->is_ongoing)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                                Ongoing
                                            </span>
                                        @endif
                                        <button onclick="openModal('educationModal', {{ $education->id }})" 
                                                class="p-1 text-gray-400 hover:text-[#1a237e] hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteItem('education', {{ $education->id }})" 
                                                class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8" id="emptyEducation">
                            <div class="w-14 h-14 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">No education added yet</p>
                            <p class="text-xs text-gray-400">Add your educational background</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ===== CERTIFICATES SECTION ===== -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Licenses &amp; certifications</h3>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="openModal('certificateModal', null)" 
                                class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center transition-colors">
                            <svg class="w-4.5 h-4.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-5 pb-5" id="certificateList">
                    @forelse($user->certificates as $certificate)
                        <div class="relative flex gap-4 {{ !$loop->last ? 'pb-6' : '' }} certificate-item" data-id="{{ $certificate->id }}">
                            @if(!$loop->last)
                                <span class="absolute left-6 top-14 bottom-0 w-px bg-gray-200"></span>
                            @endif
                            <div class="relative z-10 w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <div class="flex items-start justify-between gap-2 flex-wrap">
                                    <div>
                                        <p class="font-semibold text-gray-900 text-[15px]">{{ $certificate->sertification_title ?? 'Certificate' }}</p>
                                        <p class="text-sm text-gray-600">{{ $certificate->institute_name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $certificate->period }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        @if($certificate->is_ongoing)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                                Ongoing
                                            </span>
                                        @endif
                                        <button onclick="openModal('certificateModal', {{ $certificate->id }})" 
                                                class="p-1 text-gray-400 hover:text-[#1a237e] hover:bg-gray-100 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteItem('certificate', {{ $certificate->id }})" 
                                                class="p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8" id="emptyCertificate">
                            <div class="w-14 h-14 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">No certificates added yet</p>
                            <p class="text-xs text-gray-400">Add your certifications</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ============ SIDEBAR ============ -->
        <div class="space-y-4">

            <!-- Profile strength -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold text-gray-900">Profile strength</h3>
                    <span class="text-xs font-semibold text-[#1a237e]">{{ $completenessLabel }}</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-[#1a237e] rounded-full" style="width: {{ $completenessPercent }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    @if($completenessPercent >= 100)
                        Your profile has everything recruiters look for.
                    @elseif(!$user->experiences->count())
                        Add a work experience to stand out to recruiters.
                    @elseif(!$user->educations->count())
                        Add your education to complete your profile.
                    @elseif(!$user->certificates->count())
                        Add a certificate to boost your profile.
                    @else
                        Keep your profile up to date to get noticed.
                    @endif
                </p>
            </div>

            <!-- Resume -->
            @if($user->applicantProfile && $user->applicantProfile->resume_path)
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Resume
                </h3>
                <a href="{{ Storage::url($user->applicantProfile->resume_path) }}" target="_blank" 
                   class="flex items-center gap-2 text-sm text-[#1a237e] hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    {{ basename($user->applicantProfile->resume_path) }}
                </a>
            </div>
            @endif

            <!-- Recent jobs -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4">
                    <h3 class="text-sm font-semibold text-gray-900">Recent jobs</h3>
                    <a href="#" class="text-xs font-semibold text-[#1a237e] hover:underline">View all</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($user->jobPosts as $job)
                        <div class="flex items-center justify-between gap-2 px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $job->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium shrink-0
                                @if($job->status === 'published') bg-emerald-50 text-emerald-700
                                @elseif($job->status === 'draft') bg-amber-50 text-amber-700
                                @else bg-gray-100 text-gray-600
                                @endif">
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 px-5">
                            <p class="text-sm text-gray-500">No jobs posted yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent applications -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4">
                    <h3 class="text-sm font-semibold text-gray-900">Recent applications</h3>
                    <a href="#" class="text-xs font-semibold text-[#1a237e] hover:underline">View all</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($user->applications as $application)
                        <div class="flex items-center justify-between gap-2 px-5 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $application->jobPost->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-400">{{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium shrink-0
                                @if($application->status === 'hired') bg-emerald-50 text-emerald-700
                                @elseif($application->status === 'shortlisted') bg-purple-50 text-purple-700
                                @elseif($application->status === 'interviewing') bg-blue-50 text-blue-700
                                @elseif($application->status === 'pending') bg-amber-50 text-amber-700
                                @else bg-red-50 text-red-700
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 px-5">
                            <p class="text-sm text-gray-500">No applications submitted</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== MODALS ===== -->
<!-- ============================================================ -->

<!-- ===== EDUCATION MODAL ===== -->
<div id="educationModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900" id="educationModalTitle">Add Education</h3>
            <button onclick="closeModal('educationModal')" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="educationForm" class="p-6 space-y-4" onsubmit="submitEducation(event)">
            @csrf
            <input type="hidden" id="education_id" name="education_id" value="">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Institute Name</label>
                <input type="text" id="education_institute" name="institute_name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Degree / Education Title</label>
                <input type="text" id="education_title" name="education_title" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="education_desc" name="description" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="education_start" name="start_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="education_end" name="end_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="education_ongoing" name="on_going" value="1" 
                           class="w-4 h-4 rounded border-gray-300 text-[#0a66c2] focus:ring-[#0a66c2]">
                    <span class="text-sm text-gray-700">Currently studying here</span>
                </label>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" id="education_country" name="country" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input type="text" id="education_state" name="state" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" id="education_city" name="city" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#0a66c2] hover:bg-[#004182] text-white font-medium rounded-lg transition-colors">
                    Save Education
                </button>
                <button type="button" onclick="closeModal('educationModal')" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== EXPERIENCE MODAL ===== -->
<div id="experienceModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900" id="experienceModalTitle">Add Experience</h3>
            <button onclick="closeModal('experienceModal')" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="experienceForm" class="p-6 space-y-4" onsubmit="submitExperience(event)">
            @csrf
            <input type="hidden" id="experience_id" name="experience_id" value="">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <input type="text" id="experience_company" name="company_name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                <input type="text" id="experience_job_title" name="job_title" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="experience_desc" name="description" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="experience_start" name="start_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="experience_end" name="end_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="experience_ongoing" name="on_going" value="1" 
                           class="w-4 h-4 rounded border-gray-300 text-[#0a66c2] focus:ring-[#0a66c2]">
                    <span class="text-sm text-gray-700">I currently work here</span>
                </label>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" id="experience_country" name="country" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input type="text" id="experience_state" name="state" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" id="experience_city" name="city" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#0a66c2] hover:bg-[#004182] text-white font-medium rounded-lg transition-colors">
                    Save Experience
                </button>
                <button type="button" onclick="closeModal('experienceModal')" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== CERTIFICATE MODAL ===== -->
<div id="certificateModal" class="modal-overlay">
    <div class="modal-content bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900" id="certificateModalTitle">Add Certificate</h3>
            <button onclick="closeModal('certificateModal')" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="certificateForm" class="p-6 space-y-4" onsubmit="submitCertificate(event)">
            @csrf
            <input type="hidden" id="certificate_id" name="certificate_id" value="">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Institute Name</label>
                <input type="text" id="certificate_institute" name="institute_name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificate Title</label>
                <input type="text" id="certificate_title" name="sertification_title" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="certificate_desc" name="description" rows="3" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="certificate_start" name="start_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="certificate_end" name="end_date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="certificate_ongoing" name="on_going" value="1" 
                           class="w-4 h-4 rounded border-gray-300 text-[#0a66c2] focus:ring-[#0a66c2]">
                    <span class="text-sm text-gray-700">Currently pursuing this certification</span>
                </label>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" id="certificate_country" name="country" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input type="text" id="certificate_state" name="state" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" id="certificate_city" name="city" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#0a66c2] hover:bg-[#004182] text-white font-medium rounded-lg transition-colors">
                    Save Certificate
                </button>
                <button type="button" onclick="closeModal('certificateModal')" 
                        class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ===== MODAL FUNCTIONS =====
    function openModal(modalId, id = null) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        // Reset form
        const form = modal.querySelector('form');
        if (form) form.reset();

        // Reset ongoing checkbox and enable end date
        const ongoingCheckbox = form?.querySelector('[id$="_ongoing"]');
        if (ongoingCheckbox) {
            ongoingCheckbox.checked = false;
            const endDateField = document.getElementById(ongoingCheckbox.id.replace('_ongoing', '_end'));
            if (endDateField) {
                endDateField.disabled = false;
                endDateField.value = '';
            }
        }

        // Set title and hidden fields
        const type = modalId.replace('Modal', '');
        const titleEl = document.getElementById(modalId + 'Title');
        
        if (id) {
            titleEl.textContent = 'Edit ' + type.charAt(0).toUpperCase() + type.slice(1);
            document.getElementById(type + '_id').value = id;
            loadData(type, id);
        } else {
            titleEl.textContent = 'Add ' + type.charAt(0).toUpperCase() + type.slice(1);
            document.getElementById(type + '_id').value = '';
        }

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

   function loadData(type, id) {

    let items = [];

    if (type === 'education') {
        items = @json($user->educations);
    } else if (type === 'experience') {
        items = @json($user->experiences);
    } else if (type === 'certificate') {
        items = @json($user->certificates);
    }

    console.log('Loading:', type, 'ID:', id);
    console.log('Items:', items);

    const item = items.find(item => parseInt(item.id) === parseInt(id));

    if (!item) {
        console.error('Item not found:', id);
        return;
    }

    console.log('Selected item:', item);

    /*
     * DB FIELD => HTML ELEMENT ID
     */
    const fieldMappings = {

        education: {
            institute_name: 'education_institute',
            education_title: 'education_title',
            description: 'education_desc',
            start_date: 'education_start',
            end_date: 'education_end',
            on_going: 'education_ongoing',
            country: 'education_country',
            state: 'education_state',
            city: 'education_city'
        },

        experience: {
            company_name: 'experience_company',
            job_title: 'experience_job_title',
            description: 'experience_desc',
            start_date: 'experience_start',
            end_date: 'experience_end',
            on_going: 'experience_ongoing',
            country: 'experience_country',
            state: 'experience_state',
            city: 'experience_city'
        },

        certificate: {
            institute_name: 'certificate_institute',
            sertification_title: 'certificate_title',
            description: 'certificate_desc',
            start_date: 'certificate_start',
            end_date: 'certificate_end',
            on_going: 'certificate_ongoing',
            country: 'certificate_country',
            state: 'certificate_state',
            city: 'certificate_city'
        }
    };

    const mappings = fieldMappings[type];

    if (!mappings) {
        console.error('Invalid type:', type);
        return;
    }

    Object.keys(mappings).forEach(dbField => {

        const elementId = mappings[dbField];
        const el = document.getElementById(elementId);

        if (!el) {
            console.warn('Element not found:', elementId);
            return;
        }

        const value = item[dbField];

        console.log(
            'Setting:',
            elementId,
            '<=',
            dbField,
            value
        );

        // Checkbox
        if (dbField === 'on_going') {

            el.checked =
                value == 1 ||
                value === true ||
                value === '1' ||
                value === 'yes' ||
                value === 'on';

            // Enable / disable end date
            const endDateId = mappings.end_date;
            const endDate = document.getElementById(endDateId);

            if (endDate) {
                endDate.disabled = el.checked;

                if (el.checked) {
                    endDate.value = '';
                }
            }

        }

        // Date
        else if (dbField === 'start_date' || dbField === 'end_date') {

            if (value) {

                // Handle Laravel date formats
                const date = new Date(value);

                if (!isNaN(date.getTime())) {
                    el.value = date.toISOString().split('T')[0];
                } else {
                    // Fallback if already YYYY-MM-DD
                    el.value = String(value).substring(0, 10);
                }

            } else {
                el.value = '';
            }

        }

        // Normal input / textarea
        else {
            el.value = value ?? '';
        }
    });
}

    // ===== SUBMIT FUNCTIONS =====
    function submitEducation(event) {
        event.preventDefault();
        const id = document.getElementById('education_id').value;
        const url = id ? '/candidate/education/' + id : '/candidate/education';
        const method = id ? 'PUT' : 'POST';
        
        const data = {
            institute_name: document.getElementById('education_institute').value,
            education_title: document.getElementById('education_title').value,
            description: document.getElementById('education_desc').value,
            start_date: document.getElementById('education_start').value,
            end_date: document.getElementById('education_end').value,
            on_going: document.getElementById('education_ongoing').checked ? 1 : 0,
            country: document.getElementById('education_country').value,
            state: document.getElementById('education_state').value,
            city: document.getElementById('education_city').value,
        };

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeModal('educationModal');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Education saved successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Something went wrong'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Something went wrong'
            });
        });
    }

    function submitExperience(event) {
        event.preventDefault();
        const id = document.getElementById('experience_id').value;
        const url = id ? '/candidate/experience/' + id : '/candidate/experience';
        const method = id ? 'PUT' : 'POST';
        
        const data = {
            company_name: document.getElementById('experience_company').value,
            job_title: document.getElementById('experience_job_title').value,
            description: document.getElementById('experience_desc').value,
            start_date: document.getElementById('experience_start').value,
            end_date: document.getElementById('experience_end').value,
            on_going: document.getElementById('experience_ongoing').checked ? 1 : 0,
            country: document.getElementById('experience_country').value,
            state: document.getElementById('experience_state').value,
            city: document.getElementById('experience_city').value,
        };

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeModal('experienceModal');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Experience saved successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Something went wrong'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Something went wrong'
            });
        });
    }

    function submitCertificate(event) {
        event.preventDefault();
        const id = document.getElementById('certificate_id').value;
        const url = id ? '/candidate/certificate/' + id : '/candidate/certificate';
        const method = id ? 'PUT' : 'POST';
        
        const data = {
            institute_name: document.getElementById('certificate_institute').value,
            sertification_title: document.getElementById('certificate_title').value,
            description: document.getElementById('certificate_desc').value,
            start_date: document.getElementById('certificate_start').value,
            end_date: document.getElementById('certificate_end').value,
            on_going: document.getElementById('certificate_ongoing').checked ? 1 : 0,
            country: document.getElementById('certificate_country').value,
            state: document.getElementById('certificate_state').value,
            city: document.getElementById('certificate_city').value,
        };

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeModal('certificateModal');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Certificate saved successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Something went wrong'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Something went wrong'
            });
        });
    }

    // ===== DELETE FUNCTION =====
    function deleteItem(type, id) {
        if (!confirm('Are you sure you want to delete this item?')) return;

        const urls = {
            education: '/candidate/education/' + id,
            experience: '/candidate/experience/' + id,
            certificate: '/candidate/certificate/' + id
        };

        fetch(urls[type], {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: data.message || 'Item deleted successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Something went wrong'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Something went wrong'
            });
        });
    }

    // Handle ongoing checkbox toggle for end date
    document.querySelectorAll('[id$="_ongoing"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const modalId = this.id.replace('_ongoing', '');
            const endDateField = document.getElementById(modalId + '_end');
            if (endDateField) {
                endDateField.disabled = this.checked;
                if (this.checked) endDateField.value = '';
            }
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });
</script>

@endsection