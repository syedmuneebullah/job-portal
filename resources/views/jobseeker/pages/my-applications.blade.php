{{-- resources/views/jobseeker/pages/my-applications.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'My Applications')
@section('page-title', 'My Applications')

@section('content')

<div class="bg-slate-50/50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">My <span class="text-[#ff7543]">Applications</span></h1>
                <p class="text-sm text-gray-500 mt-1">Track all your job applications in one place</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Total: <span class="font-semibold text-[#1A237E]">{{ $stats['total'] }}</span> applications</span>
                <a href="{{ route('candidate.jobs.listings') }}" 
                   class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-1"></i> Browse Jobs
                </a>
            </div>
        </div>

        <!-- ===== STATS CARDS ===== -->
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-3 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-[#1A237E]">{{ $stats['applied'] }}</p>
                <p class="text-[10px] text-gray-500">Applied</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-blue-600">{{ $stats['under_review'] }}</p>
                <p class="text-[10px] text-gray-500">Under Review</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-purple-600">{{ $stats['shortlisted'] }}</p>
                <p class="text-[10px] text-gray-500">Shortlisted</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-indigo-600">{{ $stats['interview'] }}</p>
                <p class="text-[10px] text-gray-500">Interview</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-amber-600">{{ $stats['offer'] }}</p>
                <p class="text-[10px] text-gray-500">Offer</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-emerald-600">{{ $stats['hired'] }}</p>
                <p class="text-[10px] text-gray-500">Hired</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-red-600">{{ $stats['rejected'] }}</p>
                <p class="text-[10px] text-gray-500">Rejected</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-center hover:shadow-md transition-shadow">
                <p class="text-lg font-bold text-gray-600">{{ $stats['withdrawn'] ?? 0 }}</p>
                <p class="text-[10px] text-gray-500">Withdrawn</p>
            </div>
        </div>

        <!-- ===== FILTERS ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">
            <form action="{{ route('candidate.my-applications') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by job title or company..."
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-40">
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Status</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="offer" {{ request('status') == 'offer' ? 'selected' : '' }}>Offer</option>
                        <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="w-40">
                    <input type="date" name="from_date" value="{{ request('from_date') }}" 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm"
                           placeholder="From">
                </div>
                <div class="w-40">
                    <input type="date" name="to_date" value="{{ request('to_date') }}" 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm"
                           placeholder="To">
                </div>

                <button type="submit" class="px-6 py-2.5 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('candidate.my-applications') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all duration-300">
                    Reset
                </a>
            </form>
        </div>

        <!-- ===== APPLICATIONS LIST ===== -->
        <div class="space-y-4">
            @forelse($applications as $application)
                @php
                    $job = $application->jobPost;
                    $statusColors = [
                        'applied' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'under_review' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                        'shortlisted' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'interview' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'offer' => 'bg-orange-50 text-orange-700 border-orange-200',
                        'hired' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'rejected' => 'bg-red-50 text-red-700 border-red-200',
                        'withdrawn' => 'bg-gray-50 text-gray-700 border-gray-200',
                    ];
                    $statusColor = $statusColors[$application->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    $statusIcon = [
                        'applied' => 'fas fa-paper-plane',
                        'under_review' => 'fas fa-search',
                        'shortlisted' => 'fas fa-star',
                        'interview' => 'fas fa-handshake',
                        'offer' => 'fas fa-file-signature',
                        'hired' => 'fas fa-check-circle',
                        'rejected' => 'fas fa-times-circle',
                        'withdrawn' => 'fas fa-ban',
                    ];
                    $statusIconClass = $statusIcon[$application->status] ?? 'fas fa-circle';
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 hover:shadow-xl transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5 group">
                    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                        <!-- Company Logo & Job Info -->
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0 overflow-hidden">
                                @if($job && $job->employer && $job->employer->company_logo)
                                    <img src="{{ Storage::url($job->employer->company_logo) }}" 
                                         alt="{{ $job->employer->company_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-lg font-bold">
                                        {{ $job && $job->employer ? substr($job->employer->company_name, 0, 2) : 'JD' }}
                                    </span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">
                                        {{ $job ? $job->title : 'Job Not Available' }}
                                    </h3>
                                    @if($application->ai_match_score)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs rounded-full">
                                            <i class="fas fa-robot text-[10px]"></i>
                                            {{ $application->ai_match_score }}% Match
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $job && $job->employer ? $job->employer->company_name : 'N/A' }}</p>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500 flex items-center gap-0.5">
                                        <i class="fas fa-map-marker-alt text-[#ff7543] text-[10px]"></i>
                                        {{ $job ? $job->location : 'N/A' }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-xs text-gray-400">
                                        <i class="far fa-clock mr-1"></i>
                                        Applied {{ $application->created_at->diffForHumans() }}
                                    </span>
                                    @if($application->applied_at)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-xs text-gray-400">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $application->applied_at->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                <i class="{{ $statusIconClass }} text-[10px]"></i>
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                            
                            @if(in_array($application->status, ['applied', 'under_review', 'shortlisted', 'interview', 'offer']))
                                <button onclick="withdrawApplication({{ $application->id }})" 
                                        class="text-xs text-red-500 hover:text-red-700 font-medium hover:underline transition-colors">
                                    <i class="fas fa-times mr-0.5"></i> Withdraw
                                </button>
                            @endif
                            
                            @if($job)
                                <a href="{{ route('candidate.job.details', $job->id) }}" 
                                   class="text-xs font-medium text-[#1a237e] hover:underline">
                                    <i class="fas fa-eye mr-0.5"></i> View Job
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Application Details -->
                    <div class="mt-3 pt-3 border-t border-gray-100 flex flex-wrap items-center gap-4">
                        @if($application->cover_letter)
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-envelope text-[#ff7543]"></i>
                                Cover letter included
                            </span>
                        @endif
                        @if($application->resume_path)
                            <a href="{{ Storage::url($application->resume_path) }}" target="_blank" 
                               class="text-xs text-[#1a237e] hover:underline flex items-center gap-1">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                View Resume
                            </a>
                        @endif
                        @if($application->answers && count($application->answers) > 0)
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fas fa-question-circle text-[#ff7543]"></i>
                                {{ count($application->answers) }} question{{ count($application->answers) > 1 ? 's' : '' }} answered
                            </span>
                        @endif
                        @if($application->rejection_reason)
                            <span class="text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Reason: {{ $application->rejection_reason }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">No applications yet</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mt-1">
                        You haven't applied to any jobs yet. Start your job search today!
                    </p>
                    <a href="{{ route('candidate.jobs.listings') }}" 
                       class="mt-4 inline-block px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-search mr-2"></i> Browse Jobs
                    </a>
                </div>
            @endforelse
        </div>

        <!-- ===== PAGINATION ===== -->
        <div class="mt-6">
            {{ $applications->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function withdrawApplication(id) {
        Swal.fire({
            title: 'Withdraw Application?',
            text: 'Are you sure you want to withdraw this application? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, withdraw it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/candidate/application/' + id + '/withdraw', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Withdrawn!',
                            text: data.message || 'Application withdrawn successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to withdraw application');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }
</script>

@push('styles')
<style>
    .group:hover .group-hover\:text-\[#1A237E\] {
        color: #1A237E;
    }
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endpush

@endsection