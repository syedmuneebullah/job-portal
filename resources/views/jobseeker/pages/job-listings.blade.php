{{-- resources/views/jobseeker/pages/job-listings.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Job Listings')
@section('page-title', 'Job Listings')

@section('content')

<div class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    Find Your <span class="text-[#ff7543]">Dream Job</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Discover thousands of opportunities across Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">
                    Showing <span class="font-semibold text-[#1A237E]">{{ $jobs->total() }}</span> jobs
                </span>
            </div>
        </div>

        <!-- ===== FILTERS BAR ===== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 mb-5">
            <form action="{{ route('candidate.jobs.listings') }}" method="GET"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search jobs, companies, or keywords..."
                           class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-gray-300 focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none transition-all text-sm">
                </div>

                <div class="relative">
                    <select name="work_type"
                            class="w-full pl-3 pr-9 py-2.5 rounded-lg border border-gray-300 focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Work Types</option>
                        @foreach($workTypes as $type)
                            <option value="{{ $type }}" {{ request('work_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select name="employment_type"
                            class="w-full pl-3 pr-9 py-2.5 rounded-lg border border-gray-300 focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Employment Types</option>
                        @foreach($employmentTypes as $type)
                            <option value="{{ $type }}" {{ request('employment_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>

                <button type="submit"
                        class="px-4 py-2.5 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-lg transition-all duration-300 text-sm">
                    <i class="fas fa-search mr-1.5"></i> Search
                </button>
            </form>
        </div>

        <!-- ===== MAIN CONTENT ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            <!-- ===== LEFT SIDEBAR - Job List ===== -->
            <div class="lg:col-span-5 xl:col-span-4">
                <div class="bg-white rounded-lg border border-gray-200 flex flex-col overflow-hidden"
                     style="height: calc(100vh - 220px); min-height: 500px;">

                    {{-- Scrollable Job List --}}
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-3">
                        @forelse($jobs as $job)
                            @php
                                $isActive = $selectedJob && $selectedJob->id == $job->id;
                                $isSaved = in_array($job->id, $savedJobIds ?? []);
                            @endphp
                            <a href="{{ route('candidate.jobs.listings', array_merge(request()->except('job_id'), ['job_id' => $job->id])) }}"
                               class="block bg-white rounded-lg border {{ $isActive ? 'border-[#ff7543] bg-[#fef2f0]' : 'border-gray-200 hover:border-gray-400' }} transition-all duration-200 p-4 cursor-pointer group">

                                <div class="flex gap-3">
                                    <!-- Company Logo -->
                                    <div class="w-12 h-12 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-[#1A237E] text-base font-bold shrink-0 overflow-hidden">
                                        @if($job->employer && $job->employer->company_logo)
                                            <img src="{{ Storage::url($job->employer->company_logo) }}"
                                                 alt="{{ $job->employer->company_name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-bold">
                                                {{ $job->employer ? substr($job->employer->company_name, 0, 2) : 'JD' }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-[15px] font-bold text-[#1A237E] group-hover:text-[#ff7543] group-hover:underline transition-colors truncate">
                                            {{ $job->title }}
                                        </h3>
                                        <p class="text-sm text-gray-700 truncate">{{ $job->employer?->company_name ?? 'Company' }}</p>

                                        <p class="text-sm text-gray-600 flex items-center gap-1 mt-1">
                                            <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                            {{ $job->location }}
                                        </p>

                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @if($job->employment_type)
                                                <span class="text-[11px] font-medium bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                                                    {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                                                </span>
                                            @endif
                                            @if($job->work_type)
                                                <span class="text-[11px] font-medium bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                                                    {{ ucfirst($job->work_type) }}
                                                </span>
                                            @endif
                                            @if($job->salary_min && $job->salary_max)
                                                <span class="text-[11px] font-medium bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                                                    {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }}-{{ number_format($job->salary_max) }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $job->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    @if($isActive)
                                        <div class="w-5 h-5 rounded-full bg-[#ff7543] flex items-center justify-center text-white text-[10px] shrink-0">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                                <i class="fas fa-briefcase text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-700 font-medium">No jobs found</p>
                                <p class="text-sm text-gray-500 mt-1">Try adjusting your search or filters</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination — PINNED AT BOTTOM --}}
                    @if($jobs->hasPages())
                        <div class="shrink-0 border-t border-gray-200 bg-white px-3 py-3">
                            <div class="flex items-center justify-between gap-2">
                                {{-- Previous --}}
                                @if($jobs->onFirstPage())
                                    <button disabled
                                            class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left text-[10px]"></i>
                                        Previous
                                    </button>
                                @else
                                    <a href="{{ $jobs->previousPageUrl() }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:border-[#ff7543] hover:text-[#ff7543] hover:bg-[#fef2f0] transition-all">
                                        <i class="fas fa-chevron-left text-[10px]"></i>
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Info --}}
                                <span class="text-xs font-medium text-gray-500 whitespace-nowrap">
                                    <span class="text-[#1A237E] font-bold">{{ $jobs->currentPage() }}</span> / <span class="text-[#1A237E] font-bold">{{ $jobs->lastPage() }}</span>
                                </span>

                                {{-- Next --}}
                                @if($jobs->hasMorePages())
                                    <a href="{{ $jobs->nextPageUrl() }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:border-[#ff7543] hover:text-[#ff7543] hover:bg-[#fef2f0] transition-all">
                                        Next
                                        <i class="fas fa-chevron-right text-[10px]"></i>
                                    </a>
                                @else
                                    <button disabled
                                            class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        Next
                                        <i class="fas fa-chevron-right text-[10px]"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- ===== RIGHT SIDEBAR - Job Details ===== -->
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="bg-white rounded-lg border border-gray-200 sticky top-20 flex flex-col overflow-hidden"
                     style="height: calc(100vh - 220px); min-height: 500px;">

                    @if($selectedJob)
                        @php
                            $isSelectedJobSaved = in_array($selectedJob->id, $savedJobIds ?? []);
                        @endphp

                        {{-- Scrollable Content --}}
                        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 md:p-8" id="job-details-container">

                            <!-- Header -->
                            <div class="flex items-start gap-4 pb-5 border-b border-gray-200">
                                <div class="w-16 h-16 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-[#1A237E] text-2xl font-bold shrink-0 overflow-hidden">
                                    @if($selectedJob->employer && $selectedJob->employer->company_logo)
                                        <img src="{{ Storage::url($selectedJob->employer->company_logo) }}"
                                             alt="{{ $selectedJob->employer->company_name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg font-bold">
                                            {{ $selectedJob->employer ? substr($selectedJob->employer->company_name, 0, 2) : 'JD' }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $selectedJob->title }}</h2>
                                    <p class="text-[#1A237E] font-medium mt-0.5">{{ $selectedJob->employer?->company_name ?? 'Company' }}</p>
                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                        <span class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                            {{ $selectedJob->location }}
                                        </span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-sm text-gray-500">
                                            Posted {{ $selectedJob->created_at->diffForHumans() }}
                                        </span>
                                        @if($selectedJob->closing_at)
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span class="text-sm text-amber-600">
                                                Closing {{ $selectedJob->closing_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Job Details Info -->
                            <div class="py-5 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-900 mb-3">Job details</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    @if($selectedJob->employment_type)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-briefcase text-gray-400 mt-1 text-xs w-4"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Job type</p>
                                                <p class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $selectedJob->employment_type)) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($selectedJob->work_type)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-laptop-house text-gray-400 mt-1 text-xs w-4"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Work type</p>
                                                <p class="text-gray-600">{{ ucfirst($selectedJob->work_type) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($selectedJob->experience_level)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-user-tie text-gray-400 mt-1 text-xs w-4"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Experience</p>
                                                <p class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $selectedJob->experience_level)) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($selectedJob->salary_min && $selectedJob->salary_max)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-money-bill-wave text-gray-400 mt-1 text-xs w-4"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Salary</p>
                                                <p class="text-gray-600">{{ $selectedJob->currency ?? 'RM' }} {{ number_format($selectedJob->salary_min) }} - {{ number_format($selectedJob->salary_max) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($selectedJob->closing_at)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-calendar-alt text-gray-400 mt-1 text-xs w-4"></i>
                                            <div>
                                                <p class="font-medium text-gray-900">Closing date</p>
                                                <p class="text-gray-600">{{ $selectedJob->closing_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="py-5 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-900 mb-2">Full job description</h3>
                                <p class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed">
                                    {{ Str::limit($selectedJob->description, 300) }}
                                    @if(strlen($selectedJob->description) > 300)
                                        <button onclick="toggleFullDescription()" class="text-[#ff7543] font-medium hover:underline">
                                            Read more
                                        </button>
                                    @endif
                                </p>
                                <div id="full-description" class="hidden">
                                    <p class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed mt-2">
                                        {{ substr($selectedJob->description, 300) }}
                                    </p>
                                    <button onclick="toggleFullDescription()" class="text-[#ff7543] font-medium hover:underline mt-1">
                                        Show less
                                    </button>
                                </div>
                            </div>

                            <!-- Requirements -->
                            @if($selectedJob->requirements)
                                <div class="py-5 border-b border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 mb-2">Requirements</h3>
                                    <div class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed">{{ $selectedJob->requirements }}</div>
                                </div>
                            @endif

                            <!-- Benefits -->
                            @if($selectedJob->benefits)
                                <div class="py-5 border-b border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 mb-2">Benefits</h3>
                                    <div class="text-sm text-gray-600 whitespace-pre-wrap leading-relaxed">{{ $selectedJob->benefits }}</div>
                                </div>
                            @endif

                            <!-- Skills -->
                            @php
                                $requiredSkills = is_array($selectedJob->required_skills)
                                    ? $selectedJob->required_skills
                                    : (is_string($selectedJob->required_skills) ? json_decode($selectedJob->required_skills, true) ?? [] : []);
                                $preferredSkills = is_array($selectedJob->preferred_skills)
                                    ? $selectedJob->preferred_skills
                                    : (is_string($selectedJob->preferred_skills) ? json_decode($selectedJob->preferred_skills, true) ?? [] : []);
                            @endphp

                            @if(!empty($requiredSkills) || !empty($preferredSkills))
                                <div class="py-5">
                                    @if(!empty($requiredSkills))
                                        <h3 class="text-sm font-bold text-gray-900 mb-2">Required skills</h3>
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach($requiredSkills as $skill)
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!empty($preferredSkills))
                                        <h3 class="text-sm font-bold text-gray-900 mb-2">Preferred skills</h3>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($preferredSkills as $skill)
                                                <span class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Action Buttons — PINNED AT BOTTOM --}}
                        <div class="shrink-0 border-t border-gray-200 bg-white px-6 md:px-8 py-4">
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('candidate.job.apply.form', $selectedJob->id) }}"
                                   class="px-6 py-2.5 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-lg transition-all duration-300 text-sm flex items-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Apply now
                                </a>

                                <button onclick="toggleSaveJob({{ $selectedJob->id }}, this)"
                                        class="px-6 py-2.5 border border-[#ff7543] text-[#ff7543] hover:bg-[#ff7543]/5 font-semibold rounded-lg transition-all duration-300 text-sm flex items-center gap-2"
                                        title="{{ $isSelectedJobSaved ? 'Unsave Job' : 'Save Job' }}">
                                    <i class="{{ $isSelectedJobSaved ? 'fas' : 'far' }} fa-bookmark"></i>
                                    <span>{{ $isSelectedJobSaved ? 'Saved' : 'Save' }}</span>
                                </button>

                                <button class="px-6 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold rounded-lg transition-all duration-300 text-sm flex items-center gap-2">
                                    <i class="fas fa-share-alt"></i>
                                    Share
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Select a job to view details</h3>
                            <p class="text-sm text-gray-500 max-w-sm mt-1">
                                Click on any job listing from the left panel to see the full job description, requirements, and application details.
                            </p>
                            <div class="mt-6 flex items-center gap-2 text-sm text-gray-400">
                                <i class="fas fa-arrow-left"></i>
                                <span>Select a job from the list</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ff7543; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #B71C1C; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleFullDescription() {
        const fullDesc = document.getElementById('full-description');
        const readMoreBtn = document.querySelector('button[onclick="toggleFullDescription()"]');
        if (fullDesc.classList.contains('hidden')) {
            fullDesc.classList.remove('hidden');
            if (readMoreBtn) readMoreBtn.textContent = 'Show less';
        } else {
            fullDesc.classList.add('hidden');
            if (readMoreBtn) readMoreBtn.textContent = 'Read more';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const activeJob = document.querySelector('.active-job');
        if (activeJob && window.innerWidth < 1024) {
            setTimeout(() => {
                activeJob.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        }
    });

    function toggleSaveJob(jobId, element) {
        const icon = element.querySelector('i');
        const textSpan = element.querySelector('span') || element;

        element.classList.add('opacity-50', 'pointer-events-none');

        fetch('/candidate/jobs/toggle-save', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ job_post_id: jobId })
        })
        .then(response => response.json())
        .then(data => {
            element.classList.remove('opacity-50', 'pointer-events-none');

            if (data.success) {
                if (data.is_saved) {
                    icon.className = 'fas fa-bookmark';
                    element.title = 'Unsave Job';
                    if (textSpan) textSpan.textContent = 'Saved';
                    Swal.fire({ icon: 'success', title: 'Saved!', text: 'Job saved successfully', timer: 1500, showConfirmButton: false });
                } else {
                    icon.className = 'far fa-bookmark';
                    element.title = 'Save Job';
                    if (textSpan) textSpan.textContent = 'Save';
                    Swal.fire({ icon: 'info', title: 'Unsaved', text: 'Job removed from saved list', timer: 1500, showConfirmButton: false });
                }
            } else {
                if (data.message === 'Please login to save jobs.') {
                    Swal.fire({
                        icon: 'warning', title: 'Login Required', text: 'Please login to save jobs.',
                        confirmButtonText: 'Login', showCancelButton: true, cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) window.location.href = '/login';
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error!', text: data.message || 'Something went wrong' });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            element.classList.remove('opacity-50', 'pointer-events-none');
            Swal.fire({ icon: 'error', title: 'Error!', text: 'Something went wrong. Please try again.' });
        });
    }
</script>

@endsection