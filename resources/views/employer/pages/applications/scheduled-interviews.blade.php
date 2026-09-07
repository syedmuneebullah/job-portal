@extends('employer.layouts.app')

@section('title', 'Scheduled Interviews')
@section('page-title', 'Scheduled Interviews')

@section('content')
<div class="space-y-6">

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Interviews</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $scheduledInterviews->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Upcoming</p>
                    <p class="text-2xl font-bold text-green-600">{{ $upcomingCount }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $todayCount }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $completedCount }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FILTERS & SEARCH ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('employer.interviews.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by candidate name or job title..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: Status -->
            <div class="w-full sm:w-40">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                </select>
            </div>

            <!-- Filter: Date Range -->
            <div class="w-full sm:w-36">
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       placeholder="From"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
            </div>
            <div class="w-full sm:w-36">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       placeholder="To"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
            </div>

            <!-- Per Page -->
            <div class="w-full sm:w-24">
                <select name="per_page" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                    Apply Filters
                </button>
                <a href="{{ route('employer.interviews.index') }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== INTERVIEWS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Job Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Platform</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($scheduledInterviews as $interview)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <!-- Candidate -->
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-9 h-9 rounded-full bg-[#1a237e]/10 text-[#1a237e] flex items-center justify-center text-sm font-medium">
                                    {{ $interview->application->applicant->first_name[0] ?? 'U' }}{{ $interview->application->applicant->last_name[0] ?? '' }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $interview->application->applicant->first_name ?? '' }} {{ $interview->application->applicant->last_name ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $interview->application->applicant->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Job Title -->
                        <td class="px-4 py-4 hidden md:table-cell">
                            <p class="text-sm text-gray-900">{{ $interview->jobPost->title ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $interview->jobPost->department ?? '' }}</p>
                        </td>

                        <!-- Date & Time -->
                        <td class="px-4 py-4">
                            <div class="space-y-0.5">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $interview->interview_datetime->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $interview->interview_datetime->format('h:i A') }}
                                    <span class="text-gray-400">({{ $interview->timezone ?? 'UTC' }})</span>
                                </p>
                                @if($interview->duration)
                                    <p class="text-xs text-gray-400">{{ $interview->duration }} min</p>
                                @endif
                            </div>
                        </td>

                        <!-- Platform -->
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($interview->platform === 'zoom') bg-blue-50 text-blue-700
                                @elseif($interview->platform === 'teams') bg-purple-50 text-purple-700
                                @elseif($interview->platform === 'google_meet') bg-green-50 text-green-700
                                @elseif($interview->platform === 'in_person') bg-amber-50 text-amber-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                {{ ucfirst($interview->platform ?? 'N/A') }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($interview->status === 'scheduled') bg-green-50 text-green-700
                                @elseif($interview->status === 'completed') bg-blue-50 text-blue-700
                                @elseif($interview->status === 'cancelled') bg-red-50 text-red-700
                                @elseif($interview->status === 'rescheduled') bg-amber-50 text-amber-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    @if($interview->status === 'scheduled') bg-green-500
                                    @elseif($interview->status === 'completed') bg-blue-500
                                    @elseif($interview->status === 'cancelled') bg-red-500
                                    @elseif($interview->status === 'rescheduled') bg-amber-500
                                    @else bg-gray-500
                                    @endif"></span>
                                {{ ucfirst($interview->status) }}
                            </span>
                            @if($interview->status === 'scheduled' && $interview->interview_datetime < now())
                                <span class="ml-1 text-xs text-red-500">(Overdue)</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Meeting Link -->
                                @if($interview->meeting_link)
                                    <a href="{{ $interview->meeting_link }}" 
                                       target="_blank"
                                       class="p-1.5 rounded-lg text-blue-600 hover:text-white hover:bg-blue-600 transition-all duration-200"
                                       title="Join Meeting">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                @endif

                                <!-- Reschedule Button -->
                                @if($interview->status === 'scheduled' || $interview->status === 'rescheduled')
                                    <button onclick="openRescheduleModal({{ $interview->id }})"
                                            class="p-1.5 rounded-lg text-amber-600 hover:text-white hover:bg-amber-600 transition-all duration-200"
                                            title="Reschedule">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                @endif

                                <!-- Complete Button -->
                                @if($interview->status === 'scheduled' || $interview->status === 'rescheduled')
                                    <button onclick="completeInterview({{ $interview->id }})"
                                            class="p-1.5 rounded-lg text-green-600 hover:text-white hover:bg-green-600 transition-all duration-200"
                                            title="Mark as Completed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                @endif

                                <!-- Cancel Button -->
                                @if($interview->status !== 'cancelled' && $interview->status !== 'completed')
                                    <button onclick="cancelInterview({{ $interview->id }})"
                                            class="p-1.5 rounded-lg text-red-600 hover:text-white hover:bg-red-600 transition-all duration-200"
                                            title="Cancel">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No scheduled interviews found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filters</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== TABLE FOOTER ===== -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-4 py-4 border-t border-gray-200 bg-gray-50/50">
            <div class="flex flex-wrap items-center gap-4">
                <p class="text-sm text-gray-500">
                    Showing <span class="font-medium text-gray-700">{{ $scheduledInterviews->firstItem() ?? 0 }}</span>
                    to <span class="font-medium text-gray-700">{{ $scheduledInterviews->lastItem() ?? 0 }}</span>
                    of <span class="font-medium text-gray-700">{{ $scheduledInterviews->total() }}</span> interviews
                </p>
            </div>
            <div class="w-full sm:w-auto">
                {{ $scheduledInterviews->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ===== RESCHEDULE MODAL ===== -->
<div id="rescheduleModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeRescheduleModal()"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reschedule Interview</h3>
            
            <form id="rescheduleForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Date & Time</label>
                    <input type="datetime-local" 
                           name="interview_datetime" 
                           id="reschedule_datetime"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                    <input type="number" 
                           name="duration" 
                           id="reschedule_duration"
                           value="60"
                           min="15"
                           max="300"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" 
                              id="reschedule_notes"
                              rows="3"
                              placeholder="Reason for rescheduling..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeRescheduleModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== RESCHEDULE FUNCTIONS =====
function openRescheduleModal(interviewId) {
    const modal = document.getElementById('rescheduleModal');
    const form = document.getElementById('rescheduleForm');
    
    // Set the form action
    form.action = `/employer/interviews/${interviewId}/reschedule`;
    
    // Set default datetime to 2 hours from now
    const now = new Date();
    now.setHours(now.getHours() + 2);
    document.getElementById('reschedule_datetime').value = now.toISOString().slice(0, 16);
    
    modal.classList.remove('hidden');
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').classList.add('hidden');
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRescheduleModal();
    }
});

// ===== CANCEL INTERVIEW =====
function cancelInterview(id) {
    Swal.fire({
        title: 'Cancel Interview?',
        text: 'This will cancel the interview and move the application back to shortlisted status.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/employer/interviews/${id}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled!',
                        text: 'Interview has been cancelled successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Failed to cancel interview', 'error');
            });
        }
    });
}

// ===== COMPLETE INTERVIEW =====
function completeInterview(id) {
    Swal.fire({
        title: 'Mark as Completed?',
        text: 'This will mark the interview as completed.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#1a237e',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, complete it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/employer/interviews/${id}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Completed!',
                        text: 'Interview has been marked as completed.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Failed to complete interview', 'error');
            });
        }
    });
}

// ===== RESCHEDULE FORM SUBMISSION =====
document.getElementById('rescheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Rescheduled!',
                text: 'Interview has been rescheduled successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => location.reload());
        } else {
            Swal.fire('Error', data.message || 'Failed to reschedule', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Failed to reschedule interview', 'error');
    });
});
</script>

@endsection