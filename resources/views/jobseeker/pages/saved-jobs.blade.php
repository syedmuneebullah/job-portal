{{-- resources/views/jobseeker/pages/saved-jobs.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Saved Jobs')
@section('page-title', 'Saved Jobs')

@section('content')

<div class="bg-slate-50/50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Saved <span class="text-[#ff7543]">Jobs</span></h1>
                <p class="text-sm text-gray-500 mt-1">Jobs you've saved for later</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Total: <span class="font-semibold text-[#1A237E]">{{ $stats['total'] }}</span> saved jobs</span>
                <a href="{{ route('candidate.jobs.listings') }}" 
                   class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-1"></i> Browse Jobs
                </a>
            </div>
        </div>

        <!-- ===== STATS CARDS ===== -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <p class="text-2xl font-bold text-[#1A237E]">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total Saved</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['saved'] }}</p>
                <p class="text-xs text-gray-500">Saved</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['applied'] }}</p>
                <p class="text-xs text-gray-500">Applied</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <p class="text-2xl font-bold text-gray-600">{{ $stats['archived'] }}</p>
                <p class="text-xs text-gray-500">Archived</p>
            </div>
        </div>

        <!-- ===== FILTERS ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">
            <form action="{{ route('candidate.saved-jobs.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search saved jobs..."
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-40">
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Status</option>
                        <option value="saved" {{ request('status') == 'saved' ? 'selected' : '' }}>Saved</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Applied</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Per Page -->
                <div class="w-24">
                    <select name="per_page" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-2.5 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('candidate.saved-jobs.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all duration-300">
                    Reset
                </a>
            </form>
        </div>

        <!-- ===== SAVED JOBS LIST ===== -->
        <div class="space-y-4">
            @forelse($savedJobs as $savedJob)
                @php
                    $job = $savedJob->jobPost;
                    $statusColors = [
                        'saved' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'applied' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'archived' => 'bg-gray-50 text-gray-700 border-gray-200',
                    ];
                    $statusColor = $statusColors[$savedJob->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                    $statusIcon = [
                        'saved' => 'fas fa-bookmark',
                        'applied' => 'fas fa-paper-plane',
                        'archived' => 'fas fa-archive',
                    ];
                    $statusIconClass = $statusIcon[$savedJob->status] ?? 'fas fa-circle';
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
                                    @if($savedJob->status === 'applied')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs rounded-full">
                                            <i class="fas fa-check-circle text-[10px]"></i>
                                            Applied
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
                                        Saved {{ $savedJob->created_at->diffForHumans() }}
                                    </span>
                                    @if($savedJob->applied_at)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-xs text-gray-400">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            Applied {{ $savedJob->applied_at->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                <i class="{{ $statusIconClass }} text-[10px]"></i>
                                {{ ucfirst($savedJob->status) }}
                            </span>
                            
                            @if($savedJob->status === 'saved')
                                <button onclick="markAsApplied({{ $savedJob->id }}, {{ $job->id }})" 
                                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium hover:underline transition-colors">
                                    <i class="fas fa-check mr-0.5"></i> Mark Applied
                                </button>
                            @endif
                            
                            @if($savedJob->status !== 'archived')
                                <button onclick="archiveJob({{ $savedJob->id }})" 
                                        class="text-xs text-gray-500 hover:text-gray-700 font-medium hover:underline transition-colors">
                                    <i class="fas fa-archive mr-0.5"></i> Archive
                                </button>
                            @endif
                            
                            <button onclick="removeSavedJob({{ $savedJob->id }})" 
                                    class="text-xs text-red-500 hover:text-red-700 font-medium hover:underline transition-colors">
                                <i class="fas fa-trash mr-0.5"></i> Remove
                            </button>
                            
                            @if($job)
                                <a href="{{ route('candidate.job.details', $job->id) }}" 
                                   class="text-xs font-medium text-[#1a237e] hover:underline">
                                    <i class="fas fa-eye mr-0.5"></i> View Job
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($savedJob->notes)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-600 flex items-start gap-1">
                                <i class="fas fa-sticky-note text-[#ff7543] mt-0.5"></i>
                                <span>{{ $savedJob->notes }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-bookmark text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">No saved jobs</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mt-1">
                        You haven't saved any jobs yet. Browse jobs and save the ones you're interested in!
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
            {{ $savedJobs->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ===== REMOVE SAVED JOB =====
    function removeSavedJob(id) {
        Swal.fire({
            title: 'Remove Saved Job?',
            text: 'This job will be removed from your saved list.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/candidate/jobs/unsave/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: data.message || 'Job removed from saved list.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to remove job');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== ARCHIVE JOB =====
    function archiveJob(id) {
        Swal.fire({
            title: 'Archive Job?',
            text: 'This job will be archived and moved out of your main saved list.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, archive it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/candidate/saved-jobs/' + id, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'archived' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Archived!',
                            text: data.message || 'Job archived successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to archive job');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== MARK AS APPLIED =====
    function markAsApplied(savedJobId, jobPostId) {
        Swal.fire({
            title: 'Mark as Applied?',
            text: 'This will mark the job as applied and move it to your applications.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, mark as applied!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/candidate/saved-jobs/' + savedJobId, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'applied' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Also create an application record
                        return fetch('/candidate/job/quick-apply', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ job_post_id: jobPostId })
                        });
                    } else {
                        throw new Error(data.message || 'Failed to update status');
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Applied!',
                            text: 'Job marked as applied successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to apply');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== RESTORE ARCHIVED JOB =====
    function restoreJob(id) {
        Swal.fire({
            title: 'Restore Job?',
            text: 'This job will be restored to your saved list.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/candidate/saved-jobs/' + id, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'saved' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Restored!',
                            text: data.message || 'Job restored successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to restore job');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== BULK ACTIONS =====
    function bulkAction(action) {
        const selected = document.querySelectorAll('.saved-job-checkbox:checked');
        
        if (selected.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one job.',
                confirmButtonColor: '#ff7543'
            });
            return;
        }

        const ids = Array.from(selected).map(cb => cb.value);
        const count = ids.length;

        let title, text, icon, confirmText, confirmColor;
        
        if (action === 'archive') {
            title = 'Archive Selected Jobs?';
            text = `You are about to archive ${count} job(s).`;
            icon = 'question';
            confirmText = 'Yes, archive them!';
            confirmColor = '#1a237e';
        } else if (action === 'remove') {
            title = 'Remove Selected Jobs?';
            text = `You are about to remove ${count} job(s) from your saved list.`;
            icon = 'warning';
            confirmText = 'Yes, remove them!';
            confirmColor = '#d33';
        } else if (action === 'apply') {
            title = 'Mark as Applied?';
            text = `You are about to mark ${count} job(s) as applied.`;
            icon = 'question';
            confirmText = 'Yes, mark them!';
            confirmColor = '#22c55e';
        } else {
            return;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const promises = ids.map(id => {
                    let url = '/candidate/saved-jobs/' + id;
                    let method = 'PUT';
                    let body = { status: action === 'archive' ? 'archived' : (action === 'apply' ? 'applied' : 'saved') };
                    
                    if (action === 'remove') {
                        url = '/candidate/jobs/unsave/' + id;
                        method = 'DELETE';
                        body = null;
                    }
                    
                    return fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: body ? JSON.stringify(body) : null
                    });
                });

                return Promise.all(promises)
                    .then(responses => Promise.all(responses.map(r => r.json())))
                    .then(results => {
                        const successCount = results.filter(r => r.success).length;
                        if (successCount === count) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: `${successCount} job(s) updated successfully.`,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(`${successCount} out of ${count} jobs updated.`);
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

@endsection