@extends('employer.layouts.app')

@section('title', 'Job Applications')
@section('page-title', 'Applications Management')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER WITH STATS ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Interview Applications</h2>
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

    <!-- ===== FILTERS & SEARCH ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('employer.applications.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name, email, job title..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: Job Post -->
            <div class="w-full sm:w-48">
                <select name="job_post_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Jobs</option>
                    @foreach($jobPosts ?? [] as $job)
                        <option value="{{ $job->id }}" {{ request('job_post_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter: Status -->
            <div class="w-full sm:w-32">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                    <option value="interviewing" {{ request('status') == 'interviewing' ? 'selected' : '' }}>Interviewing</option>
                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                <a href="{{ route('employer.applications.index') }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 text-center">
                    Reset
                </a>
                <button type="button" id="exportBtn" class="flex-1 sm:flex-none px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all duration-200">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export
                </button>
            </div>
        </form>
    </div>

    <!-- ===== APPLICATIONS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Job Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Applied Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $application)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                       
                        <!-- Applicant -->
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-9 h-9 rounded-full bg-[#1a237e]/10 text-[#1a237e] flex items-center justify-center text-sm font-medium">
                                    {{ $application->applicant->first_name[0] ?? 'U' }}{{ $application->applicant->last_name[0] ?? '' }}
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-sm font-medium text-gray-900 hover:text-[#1a237e] transition-colors">
                                        {{ $application->applicant->first_name ?? '' }} {{ $application->applicant->last_name ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $application->applicant->email ?? '' }}</p>
                                    @if($application->applicant->phone)
                                        <p class="text-xs text-gray-400">{{ $application->applicant->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Job Title -->
                        <td class="px-4 py-4 hidden md:table-cell">
                            <div class="space-y-0.5">
                                <a href="{{ route('employer.jobs.show', $application->jobPost->id ?? 0) }}"
                                   class="text-sm text-gray-900 hover:text-[#1a237e] transition-colors">
                                    {{ $application->jobPost->title ?? 'N/A' }}
                                </a>
                                <p class="text-xs text-gray-500">{{ $application->jobPost->department ?? '' }}</p>
                            </div>
                        </td>

                        <!-- Applied Date -->
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <div class="space-y-0.5">
                                <p class="text-sm text-gray-800">
                                    {{ $application->applied_at ? $application->applied_at->format('M d, Y') : $application->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $application->applied_at ? $application->applied_at->diffForHumans() : $application->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($application->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($application->status === 'shortlisted') bg-blue-50 text-blue-700
                                @elseif($application->status === 'interviewing') bg-purple-50 text-purple-700
                                @elseif($application->status === 'hired') bg-emerald-50 text-emerald-700
                                @elseif($application->status === 'rejected') bg-red-50 text-red-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    @if($application->status === 'pending') bg-amber-500
                                    @elseif($application->status === 'shortlisted') bg-blue-500
                                    @elseif($application->status === 'interviewing') bg-purple-500
                                    @elseif($application->status === 'hired') bg-emerald-500
                                    @elseif($application->status === 'rejected') bg-red-500
                                    @else bg-gray-500
                                    @endif"></span>
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- View Button -->
                                <a href="{{ route('employer.applications.show', $application->id) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>

                                <!-- Schedule Interview Button / Join Meeting Button -->
                                @if($application->scheduleInterview && $application->scheduleInterview->meeting_link)
                                    <a href="{{ $application->scheduleInterview->meeting_link }}" 
                                    target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200"
                                    title="Join Meeting">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Join Meeting
                                    </a>
                                @else
                                    <button onclick="openScheduleModal(event, {{ $application->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-all duration-200"
                                            title="Schedule Interview"
                                            id="schedule-btn-{{ $application->id }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m0 0h-2m2 0h2"/>
                                        </svg>
                                        <span id="btn-text-{{ $application->id }}">Schedule Interview</span>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No applications found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filters</p>
                                <a href="{{ route('employer.jobs.index') }}" class="mt-4 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                                    View Your Jobs
                                </a>
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
                    Showing <span class="font-medium text-gray-700">{{ $applications->firstItem() ?? 0 }}</span>
                    to <span class="font-medium text-gray-700">{{ $applications->lastItem() ?? 0 }}</span>
                    of <span class="font-medium text-gray-700">{{ $applications->total() }}</span> results
                </p>
            </div>
            <div class="w-full sm:w-auto">
                {{ $applications->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ===== SCHEDULE INTERVIEW MODAL (CENTERED) ===== -->
<div id="scheduleModal" class="fixed inset-0 z-50 hidden" style="display:none;">
    <!-- Backdrop with blur -->
    <div class="fixed inset-0 backdrop-blur-sm bg-black/30 transition-opacity" onclick="closeScheduleModal()"></div>
    
    <!-- Modal Container - Centered -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto relative transform transition-all">
            <!-- Close button -->
            <button type="button" 
                    onclick="closeScheduleModal()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Schedule Interview</h3>
                
                <form id="scheduleForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="interview_datetime" 
                               id="interview_datetime"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-[#1a237e] outline-none transition"
                               required>
                        <p class="text-xs text-gray-400 mt-1">Select the date and time for the interview</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                        <select name="duration" id="interview_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-[#1a237e] outline-none transition">
                            <option value="15">15 minutes</option>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60" selected>60 minutes</option>
                            <option value="90">90 minutes</option>
                            <option value="120">120 minutes</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                        <select name="timezone" id="interview_timezone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-[#1a237e] outline-none transition">
                            <option value="UTC">UTC</option>
                            <option value="Asia/Karachi" selected>Asia/Karachi (PKT - Pakistan Standard Time)</option>
                            <option value="Asia/Kolkata">Asia/Kolkata (IST - India Standard Time)</option>
                            <option value="America/New_York">America/New_York (EST - Eastern Time)</option>
                            <option value="America/Los_Angeles">America/Los_Angeles (PST - Pacific Time)</option>
                            <option value="Europe/London">Europe/London (GMT - Greenwich Mean Time)</option>
                            <option value="Europe/Paris">Europe/Paris (CET - Central European Time)</option>
                            <option value="Australia/Sydney">Australia/Sydney (AEST - Australian Eastern Time)</option>
                            <option value="Asia/Dubai">Asia/Dubai (GST - Gulf Standard Time)</option>
                            <option value="Asia/Singapore">Asia/Singapore (SGT - Singapore Time)</option>
                            <option value="Asia/Tokyo">Asia/Tokyo (JST - Japan Standard Time)</option>
                            <option value="Asia/Shanghai">Asia/Shanghai (CST - China Standard Time)</option>
                            <option value="Europe/Berlin">Europe/Berlin (CET - Central European Time)</option>
                            <option value="Europe/Moscow">Europe/Moscow (MSK - Moscow Time)</option>
                            <option value="America/Chicago">America/Chicago (CT - Central Time)</option>
                            <option value="America/Denver">America/Denver (MT - Mountain Time)</option>
                            <option value="America/Phoenix">America/Phoenix (MST - Mountain Standard Time)</option>
                            <option value="America/Toronto">America/Toronto (ET - Eastern Time)</option>
                            <option value="America/Vancouver">America/Vancouver (PT - Pacific Time)</option>
                            <option value="Pacific/Auckland">Pacific/Auckland (NZST - New Zealand Time)</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <textarea name="notes" 
                                  id="interview_notes"
                                  rows="3"
                                  placeholder="Any additional instructions or notes for the candidate..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-[#1a237e] outline-none transition resize-none"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeScheduleModal()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                id="scheduleSubmitBtn"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Schedule Interview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== SCHEDULE MODAL FUNCTIONS =====
let currentApplicationId = null;

function openScheduleModal(event, applicationId) {
    event.preventDefault();
    event.stopPropagation();
    
    currentApplicationId = applicationId;
    const modal = document.getElementById('scheduleModal');
    
    // Set default datetime to 2 hours from now
    const now = new Date();
    now.setHours(now.getHours() + 2);
    const formattedDate = now.toISOString().slice(0, 16);
    document.getElementById('interview_datetime').value = formattedDate;
    
    // Show modal
    modal.style.display = 'block';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeScheduleModal() {
    const modal = document.getElementById('scheduleModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentApplicationId = null;
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeScheduleModal();
    }
});

// ===== SCHEDULE FORM SUBMISSION =====
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('scheduleSubmitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin h-4 w-4 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Scheduling...
    `;
    
    // Get form data
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Build the URL
    const url = `{{ route('employer.applications.schedule-interview', ['applicationId' => ':id']) }}`.replace(':id', currentApplicationId);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            closeScheduleModal();
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: '🎯 Interview Scheduled!',
                html: `
                    <div class="text-left mt-4">
                        <p class="text-sm text-gray-600 mb-3">A Zoom meeting has been created for this interview.</p>
                        <a href="${data.meeting_link || data.meeting?.join_url}" target="_blank" 
                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Join Zoom Meeting
                        </a>
                        <p class="text-xs text-gray-400 mt-2 text-center">Scheduled for: ${new Date(data.interview_datetime).toLocaleString()}</p>
                        <p class="text-xs text-gray-400 text-center">Meeting ID: ${data.meeting?.id || data.meeting_id || 'N/A'}</p>
                    </div>
                `,
                confirmButtonText: 'Refresh Page',
                confirmButtonColor: '#1a237e',
                showCancelButton: true,
                cancelButtonText: 'Stay Here',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                } else {
                    // ✅ Replace the button with "Join Meeting" link
                    const oldBtn = document.getElementById(`schedule-btn-${currentApplicationId}`);
                    if (oldBtn) {
                        // Create new anchor tag
                        const newLink = document.createElement('a');
                        newLink.href = data.meeting_link || data.meeting?.join_url;
                        newLink.target = '_blank';
                        newLink.className = 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200';
                        newLink.title = 'Join Meeting';
                        newLink.innerHTML = `
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Join Meeting
                        `;
                        
                        // Replace the button with the link
                        oldBtn.parentNode.replaceChild(newLink, oldBtn);
                    }
                }
            });
        } else {
            // Show error
            Swal.fire({
                icon: 'error',
                title: '❌ Failed to Schedule',
                text: data.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#1a237e'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: '⚠️ Connection Error',
            text: 'Failed to connect to server. Please check your internet connection and try again.',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#1a237e'
        });
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

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
</script>

@endsection