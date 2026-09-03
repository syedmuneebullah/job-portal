{{-- resources/views/jobseeker/pages/job-listings.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Job Listings')
@section('page-title', 'Job Listings')

@section('content')

<div class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Find Your <span class="text-[#ff7543]">Dream Job</span></h1>
                <p class="text-sm text-gray-500 mt-1">Discover thousands of opportunities across Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Showing <span class="font-semibold text-[#1A237E]">{{ $jobs->total() }}</span> jobs</span>
            </div>
        </div>

        <!-- ===== FILTERS BAR ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">
            <form action="{{ route('candidate.jobs.listings') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="relative lg:col-span-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search jobs, companies, or keywords..." 
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                </div>
                
                <!-- Work Type -->
                <div class="relative">
                    <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select name="work_type" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Work Types</option>
                        @foreach($workTypes as $type)
                            <option value="{{ $type }}" {{ request('work_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>

                <!-- Employment Type -->
                <div class="relative">
                    <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select name="employment_type" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Employment Types</option>
                        @foreach($employmentTypes as $type)
                            <option value="{{ $type }}" {{ request('employment_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>

                <button type="submit" class="px-4 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i> Search
                </button>
            </form>
        </div>

        <!-- ===== MAIN CONTENT: Side-by-Side Layout ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- ===== LEFT SIDEBAR - Job List ===== -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-4">
                <!-- Job Cards List -->
                <div class="space-y-3 max-h-[calc(100vh-350px)] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($jobs as $job)
                        @php
                            $isActive = $selectedJob && $selectedJob->id == $job->id;
                            $isSaved = in_array($job->id, $savedJobIds ?? []);
                        @endphp
                        <a href="{{ route('candidate.jobs.listings', array_merge(request()->except('job_id'), ['job_id' => $job->id])) }}" 
                           class="block job-card {{ $isActive ? 'active-job' : '' }} {{ $isActive ? 'border-l-4 border-l-[#ff7543]' : '' }} bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 transition-all duration-300 p-4 hover:-translate-y-0.5 cursor-pointer group"
                           data-job-id="{{ $job->id }}">
                            <div class="flex gap-3">
                                <!-- Company Logo -->
                                <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-lg font-bold shrink-0 overflow-hidden">
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
                                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors truncate">
                                        {{ $job->title }}
                                    </h3>
                                    <p class="text-xs text-gray-600">{{ $job->employer?->company_name ?? 'Company' }}</p>
                                    <div class="flex flex-wrap items-center gap-1 mt-1">
                                        <span class="text-xs text-gray-500 flex items-center gap-0.5">
                                            <i class="fas fa-map-marker-alt text-[#ff7543] text-[10px]"></i>
                                            {{ $job->location }}
                                        </span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1 mt-1.5">
                                        @if($job->employment_type)
                                            <span class="text-[10px] font-medium bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">
                                                {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                                            </span>
                                        @endif
                                        @if($job->work_type)
                                            <span class="text-[10px] font-medium 
                                                @if($job->work_type === 'remote') bg-blue-50 text-blue-700
                                                @elseif($job->work_type === 'hybrid') bg-orange-50 text-orange-700
                                                @else bg-gray-50 text-gray-700
                                                @endif px-2 py-0.5 rounded-full">
                                                {{ ucfirst($job->work_type) }}
                                            </span>
                                        @endif
                                        @if($job->salary_min && $job->salary_max)
                                            <span class="text-[10px] font-medium bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">
                                                {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min) }}-{{ number_format($job->salary_max) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    @if($isActive)
                                        <div class="w-6 h-6 rounded-full bg-[#ff7543] flex items-center justify-center text-white text-xs font-bold shrink-0">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                                <i class="fas fa-briefcase text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium mt-3">No jobs found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your search or filters</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pt-4">
                    {{ $jobs->appends(request()->except('job_id'))->links() }}
                </div>
            </div>

            <!-- ===== RIGHT SIDEBAR - Job Details ===== -->
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 min-h-[500px] sticky top-20">
                    @if($selectedJob)
                        @php
                            // Check if selected job is saved
                            $isSelectedJobSaved = in_array($selectedJob->id, $savedJobIds ?? []);
                        @endphp
                        <div class="p-6 md:p-8" id="job-details-container">
                            <!-- Company Logo & Header -->
                            <div class="flex items-start gap-4 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-2xl font-bold shrink-0 overflow-hidden">
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
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $selectedJob->title }}</h2>
                                    <p class="text-gray-600">{{ $selectedJob->employer?->company_name ?? 'Company' }}</p>
                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                        <span class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
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

                            <!-- Quick Info Tags -->
                            <div class="flex flex-wrap gap-2 mb-6 pb-6 border-b border-gray-100">
                                @if($selectedJob->employment_type)
                                    <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $selectedJob->employment_type)) }}
                                    </span>
                                @endif
                                @if($selectedJob->work_type)
                                    <span class="text-xs font-medium 
                                        @if($selectedJob->work_type === 'remote') bg-blue-50 text-blue-700
                                        @elseif($selectedJob->work_type === 'hybrid') bg-orange-50 text-orange-700
                                        @else bg-gray-50 text-gray-700
                                        @endif px-3 py-1.5 rounded-full">
                                        {{ ucfirst($selectedJob->work_type) }}
                                    </span>
                                @endif
                                @if($selectedJob->experience_level)
                                    <span class="text-xs font-medium bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $selectedJob->experience_level)) }}
                                    </span>
                                @endif
                                @if($selectedJob->salary_min && $selectedJob->salary_max)
                                    <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full">
                                        {{ $selectedJob->currency ?? 'RM' }} {{ number_format($selectedJob->salary_min) }} - {{ number_format($selectedJob->salary_max) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2">Job Description</h3>
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

                            <!-- Requirements & Benefits -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @if($selectedJob->requirements)
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Requirements</h3>
                                        <div class="text-sm text-gray-600 whitespace-pre-wrap">{{ Str::limit($selectedJob->requirements, 150) }}</div>
                                    </div>
                                @endif
                                @if($selectedJob->benefits)
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Benefits</h3>
                                        <div class="text-sm text-gray-600 whitespace-pre-wrap">{{ Str::limit($selectedJob->benefits, 150) }}</div>
                                    </div>
                                @endif
                            </div>

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
                                <div class="mb-6">
                                    @if(!empty($requiredSkills))
                                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Required Skills</h3>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach($requiredSkills as $skill)
                                                <span class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!empty($preferredSkills))
                                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Preferred Skills</h3>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($preferredSkills as $skill)
                                                <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('candidate.job.apply.form', $selectedJob->id) }}" 
                                class="flex-1 md:flex-none px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Apply Now
                                </a>
                                
                                <!-- Save Button - Using $selectedJob->id -->
                                <button onclick="toggleSaveJob({{ $selectedJob->id }}, this)" 
                                        class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50"
                                        title="{{ $isSelectedJobSaved ? 'Unsave Job' : 'Save Job' }}">
                                    <i class="{{ $isSelectedJobSaved ? 'fas' : 'far' }} fa-bookmark {{ $isSelectedJobSaved ? 'text-[#ff7543]' : 'text-gray-400' }}"></i>
                                    <span>{{ $isSelectedJobSaved ? 'Saved' : 'Save' }}</span>
                                </button>
                                
                                <button class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50">
                                    <i class="fas fa-share-alt"></i>
                                    Share
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center min-h-[500px] p-8 text-center">
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
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ff7543;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #B71C1C;
    }
    
    /* Active job card */
    .active-job {
        background-color: #fef2f0 !important;
        border-color: #ff7543 !important;
    }
    
    /* Job card hover effect */
    .job-card {
        transition: all 0.3s ease;
    }
    .job-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }
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

    // Auto-scroll to selected job on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const activeJob = document.querySelector('.active-job');
        if (activeJob && window.innerWidth < 1024) {
            setTimeout(() => {
                activeJob.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        }
    });

    // ===== SAVE JOB FUNCTIONALITY =====
    function toggleSaveJob(jobId, element) {
        // Find the icon and text span within the button
        const icon = element.querySelector('i');
        const textSpan = element.querySelector('span') || element;
        
        // Add loading state
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
            // Remove loading state
            element.classList.remove('opacity-50', 'pointer-events-none');
            
            if (data.success) {
                if (data.is_saved) {
                    // Set saved state
                    icon.className = 'fas fa-bookmark text-[#ff7543]';
                    element.title = 'Unsave Job';
                    if (textSpan) {
                        textSpan.textContent = 'Saved';
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Job saved successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    // Set unsaved state
                    icon.className = 'far fa-bookmark text-gray-400';
                    element.title = 'Save Job';
                    if (textSpan) {
                        textSpan.textContent = 'Save';
                    }
                    Swal.fire({
                        icon: 'info',
                        title: 'Unsaved',
                        text: 'Job removed from saved list',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            } else {
                if (data.message === 'Please login to save jobs.') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Login Required',
                        text: 'Please login to save jobs.',
                        confirmButtonText: 'Login',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Something went wrong'
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            element.classList.remove('opacity-50', 'pointer-events-none');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Something went wrong. Please try again.'
            });
        });
    }
</script>

@endsection