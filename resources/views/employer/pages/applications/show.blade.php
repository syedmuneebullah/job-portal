@extends('employer.layouts.app')

@section('title', 'Application Details')
@section('page-title', 'Application Details')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Application #{{ $application->id }}</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                    @if($application->status === 'pending') bg-amber-50 text-amber-700
                    @elseif($application->status === 'shortlisted') bg-blue-50 text-blue-700
                    @elseif($application->status === 'interviewing') bg-purple-50 text-purple-700
                    @elseif($application->status === 'hired') bg-emerald-50 text-emerald-700
                    @elseif($application->status === 'rejected') bg-red-50 text-red-700
                    @endif">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                        @if($application->status === 'pending') bg-amber-500
                        @elseif($application->status === 'shortlisted') bg-blue-500
                        @elseif($application->status === 'interviewing') bg-purple-500
                        @elseif($application->status === 'hired') bg-emerald-500
                        @elseif($application->status === 'rejected') bg-red-500
                        @endif"></span>
                    {{ ucfirst($application->status) }}
                </span>
                <span class="text-gray-300">|</span>
                <span class="text-gray-500 text-sm">Applied {{ $application->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('employer.applications.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Applications
            </a>
        </div>
    </div>

    <!-- ===== MAIN GRID: content + sidebar ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">

        <!-- ============ MAIN COLUMN (2/3) ============ -->
        <div class="lg:col-span-2 space-y-4">

            <!-- ===== APPLICATION INFORMATION ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">Application Information</h3>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        @if($application->status === 'pending') bg-amber-50 text-amber-700
                        @elseif($application->status === 'shortlisted') bg-blue-50 text-blue-700
                        @elseif($application->status === 'interviewing') bg-purple-50 text-purple-700
                        @elseif($application->status === 'hired') bg-emerald-50 text-emerald-700
                        @elseif($application->status === 'rejected') bg-red-50 text-red-700
                        @endif">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                            @if($application->status === 'pending') bg-amber-500
                            @elseif($application->status === 'shortlisted') bg-blue-500
                            @elseif($application->status === 'interviewing') bg-purple-500
                            @elseif($application->status === 'hired') bg-emerald-500
                            @elseif($application->status === 'rejected') bg-red-500
                            @endif"></span>
                        {{ ucfirst($application->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant Name</label>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-8 h-8 rounded-full bg-[#1a237e]/10 text-[#1a237e] flex items-center justify-center text-sm font-medium">
                                    {{ $application->applicant->first_name[0] ?? 'U' }}{{ $application->applicant->last_name[0] ?? '' }}
                                </div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $application->applicant->first_name ?? '' }} {{ $application->applicant->last_name ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                            <p class="text-sm text-gray-900 mt-1">
                                <a href="mailto:{{ $application->applicant->email ?? '' }}" class="text-[#1a237e] hover:underline">
                                    {{ $application->applicant->email ?? 'N/A' }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $application->applicant->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Applied For</label>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $application->jobPost->title ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Department</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $application->jobPost->department ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</label>
                            <p class="text-sm text-gray-900 mt-1">
                                {{ $application->applied_at ? $application->applied_at->format('M d, Y H:i A') : $application->created_at->format('M d, Y H:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($application->cover_letter)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Cover Letter</label>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-sm text-gray-700">
                        {{ $application->cover_letter }}
                    </div>
                </div>
                @endif

                @if($application->notes)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</label>
                    <div class="mt-2 p-4 bg-amber-50 rounded-lg text-sm text-gray-700">
                        {{ $application->notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- ===== JOB DETAILS ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Job Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</label>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $application->jobPost->title ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $application->jobPost->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Work Type</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($application->jobPost->work_type === 'remote') bg-blue-50 text-blue-700
                                    @elseif($application->jobPost->work_type === 'hybrid') bg-purple-50 text-purple-700
                                    @else bg-gray-50 text-gray-700
                                    @endif">
                                    {{ ucfirst($application->jobPost->work_type ?? 'N/A') }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Employment Type</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-700">
                                    {{ ucfirst(str_replace('_', ' ', $application->jobPost->employment_type ?? 'N/A')) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Salary Range</label>
                            <p class="text-sm text-gray-900 mt-1">
                                @if($application->jobPost->salary_min && $application->jobPost->salary_max)
                                    {{ $application->jobPost->currency ?? 'USD' }} {{ number_format($application->jobPost->salary_min) }} - {{ number_format($application->jobPost->salary_max) }}
                                @else
                                    <span class="text-gray-400">Not specified</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Posted Date</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $application->jobPost->created_at ? $application->jobPost->created_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== APPLICATION TIMELINE ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Application Timeline</h3>
                <div class="relative pl-6 space-y-6 before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                    <!-- Applied -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[22px] top-0.5 w-3 h-3 rounded-full bg-[#1a237e] ring-4 ring-white"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Applied</p>
                            <p class="text-xs text-gray-500">{{ $application->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>

                    <!-- Status Updated -->
                    @if($application->status_updated_at)
                    <div class="relative pl-6">
                        <div class="absolute -left-[22px] top-0.5 w-3 h-3 rounded-full
                            @if($application->status === 'hired') bg-emerald-500
                            @elseif($application->status === 'rejected') bg-red-500
                            @elseif($application->status === 'shortlisted') bg-blue-500
                            @elseif($application->status === 'interviewing') bg-purple-500
                            @else bg-amber-500
                            @endif ring-4 ring-white">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Status Updated</p>
                            <p class="text-xs text-gray-500">{{ $application->status_updated_at->format('M d, Y H:i A') }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium mt-1
                                @if($application->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($application->status === 'shortlisted') bg-blue-50 text-blue-700
                                @elseif($application->status === 'interviewing') bg-purple-50 text-purple-700
                                @elseif($application->status === 'hired') bg-emerald-50 text-emerald-700
                                @elseif($application->status === 'rejected') bg-red-50 text-red-700
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ============ SIDEBAR (1/3) ============ -->
        <div class="space-y-4">

            <!-- Actions -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    @if($application->applicant && $application->applicant->resume && $application->applicant->resume->file_path)
                        <a href="{{ route('employer.applications.download-resume', $application->id) }}"
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Resume
                        </a>
                    @else
                        <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-400 text-sm font-medium rounded-lg cursor-not-allowed" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            No Resume Available
                        </button>
                    @endif

                    <!-- Update Status Button -->
                    <button onclick="openStatusModal()"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update Status
                    </button>

                    <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-lg hover:bg-emerald-100 transition-all duration-200 schedule-interview">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Schedule Interview
                    </button>

                    <button onclick="confirmDelete({{ $application->id }})"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Application
                    </button>

                    <!-- Hidden Forms -->
                    <form id="delete-form-{{ $application->id }}"
                          action="{{ route('employer.applications.destroy', $application->id) }}"
                          method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            
        </div>
    </div>
</div>

<!-- ===== STATUS UPDATE MODAL (Profile style) ===== -->
<div id="statusModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Update Application Status</h3>
            <button onclick="closeStatusModal()" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <input type="hidden" id="applicationId" value="{{ $application->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="statusSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none">
                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                    <option value="interviewing" {{ $application->status == 'interviewing' ? 'selected' : '' }}>Interviewing</option>
                    <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                <textarea id="statusNotes" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a66c2] focus:border-transparent outline-none"
                          placeholder="Add any notes about this status change...">{{ $application->notes }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button onclick="saveStatus()" class="px-6 py-2.5 bg-[#0a66c2] hover:bg-[#004182] text-white font-medium rounded-lg transition-colors">
                    Save Changes
                </button>
                <button onclick="closeStatusModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ===== TOAST NOTIFICATION =====
    function showToast(message, type = 'success') {
        const colors = {
            success: 'bg-emerald-500',
            error: 'bg-red-500',
            info: 'bg-blue-500',
            warning: 'bg-amber-500'
        };

        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg text-white text-sm font-medium ${colors[type] || colors.success} shadow-lg transform transition-all duration-300 translate-x-full`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 10);

        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    function openStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.classList.remove('hidden');  // ✅ Remove hidden class
    document.body.style.overflow = 'hidden';
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.classList.add('hidden');  // ✅ Add hidden class back
    document.body.style.overflow = '';
}

    // Close modal on backdrop click
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('statusModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeStatusModal();
                }
            });
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('statusModal');
            if (modal && modal.style.display === 'flex') {
                closeStatusModal();
            }
        }
    });

    // ===== SAVE STATUS =====
    function saveStatus() {
        const applicationId = document.getElementById('applicationId').value;
        const status = document.getElementById('statusSelect').value;
        const notes = document.getElementById('statusNotes').value;

        const url = '{{ route("employer.applications.update-status", ":id") }}'.replace(':id', applicationId);

        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                closeStatusModal();
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                showToast(data.message || 'Error updating status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating status', 'error');
        });
    }

    // ===== CONFIRM DELETE =====
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Application?',
            text: 'This application will be permanently deleted. This action cannot be undone.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // ===== SCHEDULE INTERVIEW =====
    document.addEventListener('DOMContentLoaded', function() {
        const scheduleBtn = document.querySelector('.schedule-interview');
        if (scheduleBtn) {
            scheduleBtn.addEventListener('click', function() {
                showToast('Interview scheduling feature coming soon!', 'info');
            });
        }
    });
</script>

@endsection
