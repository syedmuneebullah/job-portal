@extends('employer.layouts.app')

@section('title', 'Job Applications')
@section('page-title', 'Applications Management')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER WITH STATS ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Applications</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                <!-- Total Applications -->
                <a href="{{ route('employer.applications.index') }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ !request('status') ? 'text-[#1a237e] font-medium' : '' }}">
                    All <span class="font-semibold {{ !request('status') ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['total'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Pending -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'pending' ? 'text-[#1a237e] font-medium' : '' }}">
                    Pending <span class="font-semibold {{ request('status') == 'pending' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['pending'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Shortlisted -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'shortlisted']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'shortlisted' ? 'text-[#1a237e] font-medium' : '' }}">
                    Shortlisted <span class="font-semibold {{ request('status') == 'shortlisted' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['shortlisted'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Interviewing -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'interviewing']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'interviewing' ? 'text-[#1a237e] font-medium' : '' }}">
                    Interviewing <span class="font-semibold {{ request('status') == 'interviewing' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['interviewing'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Hired -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'hired']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'hired' ? 'text-[#1a237e] font-medium' : '' }}">
                    Hired <span class="font-semibold {{ request('status') == 'hired' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['hired'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Rejected -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
                   class="text-gray-600 hover:text-red-600 transition-colors whitespace-nowrap {{ request('status') == 'rejected' ? 'text-red-600 font-medium' : '' }}">
                    Rejected <span class="font-semibold {{ request('status') == 'rejected' ? 'text-red-600' : 'text-gray-900' }}">{{ $stats['rejected'] ?? 0 }}</span>
                </a>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('employer.jobs.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Jobs
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
                        <th class="px-4 py-3 text-left w-10">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </th>
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
                        <!-- Checkbox -->
                        <td class="px-4 py-4">
                            <input type="checkbox" name="selected[]" value="{{ $application->id }}"
                                   class="application-checkbox rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </td>

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
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                   title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                

                                <!-- Delete Button -->
                                <button onclick="confirmDelete({{ $application->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                <!-- Hidden Forms -->
                                <form id="delete-form-{{ $application->id }}"
                                      action="{{ route('employer.applications.destroy', $application->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <form id="status-update-form-{{ $application->id }}"
                                      action="{{ route('employer.applications.update-status', $application->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="">
                                    <input type="hidden" name="notes" value="">
                                </form>
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
                <!-- Bulk Actions -->
                <div class="flex flex-wrap items-center gap-2">
                    <select id="bulkAction" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                        <option value="">Bulk Actions</option>
                        <option value="shortlisted">Shortlist Selected</option>
                        <option value="interviewing">Move to Interviewing</option>
                        <option value="hired">Hire Selected</option>
                        <option value="rejected">Reject Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button id="applyBulkAction" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-all">
                        Apply
                    </button>
                </div>
            </div>
            <div class="w-full sm:w-auto">
                {{ $applications->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // ===== DROPDOWN TOGGLE =====
    $('.dropdown-toggle').click(function(e) {
        e.stopPropagation();
        var dropdown = $(this).siblings('.status-dropdown');
        $('.status-dropdown').not(dropdown).addClass('hidden');
        dropdown.toggleClass('hidden');
    });

    // ===== CLOSE DROPDOWN ON CLICK OUTSIDE =====
    $(document).click(function() {
        $('.status-dropdown').addClass('hidden');
    });

    // ===== STATUS UPDATE =====
    $('.status-option').click(function() {
        var status = $(this).data('status');
        var applicationId = $(this).closest('.status-dropdown').siblings('.dropdown-toggle').data('application-id');
        var form = $('#status-update-form-' + applicationId);

        form.find('input[name="status"]').val(status);
        form.submit();
    });

    // ===== SELECT ALL =====
    $('#selectAll').change(function() {
        $('.application-checkbox').prop('checked', $(this).prop('checked'));
    });

    // ===== INDIVIDUAL CHECKBOX - UPDATE SELECT ALL =====
    $('.application-checkbox').change(function() {
        if ($('.application-checkbox:checked').length == $('.application-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    // ===== EXPORT BUTTON =====
    $('#exportBtn').click(function() {
        var form = $('form');
        var action = form.attr('action');
        window.location.href = action + '/export?' + form.serialize();
    });

    // ===== BULK ACTIONS =====
    $('#applyBulkAction').click(function() {
        var action = $('#bulkAction').val();
        var selected = $('.application-checkbox:checked');

        if (!action) {
            Swal.fire('Error', 'Please select an action', 'error');
            return;
        }

        if (selected.length === 0) {
            Swal.fire('Error', 'Please select at least one application', 'error');
            return;
        }

        var ids = selected.map(function() { return $(this).val(); }).get();
        var count = selected.length;

        // Confirmation message based on action
        var title, text, icon, confirmText, endpoint;
        switch(action) {
            case 'delete':
                title = 'Delete Applications?';
                text = 'You are about to delete ' + count + ' application(s). This action cannot be undone.';
                icon = 'error';
                confirmText = 'Yes, delete them';
                endpoint = '{{ route("employer.applications.bulk-delete") }}';
                break;
            case 'shortlisted':
                title = 'Shortlist Applications?';
                text = 'You are about to shortlist ' + count + ' application(s).';
                icon = 'info';
                confirmText = 'Yes, shortlist them';
                endpoint = '{{ route("employer.applications.bulk-status") }}';
                break;
            case 'interviewing':
                title = 'Move to Interviewing?';
                text = 'You are about to move ' + count + ' application(s) to interviewing.';
                icon = 'info';
                confirmText = 'Yes, move them';
                endpoint = '{{ route("employer.applications.bulk-status") }}';
                break;
            case 'hired':
                title = 'Hire Applicants?';
                text = 'You are about to hire ' + count + ' applicant(s).';
                icon = 'success';
                confirmText = 'Yes, hire them';
                endpoint = '{{ route("employer.applications.bulk-status") }}';
                break;
            case 'rejected':
                title = 'Reject Applications?';
                text = 'You are about to reject ' + count + ' application(s).';
                icon = 'warning';
                confirmText = 'Yes, reject them';
                endpoint = '{{ route("employer.applications.bulk-status") }}';
                break;
            default:
                return;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: action === 'delete' ? '#d33' : '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                var data = {
                    ids: ids,
                    _token: '{{ csrf_token() }}'
                };

                // For status updates, add the status
                if (['shortlisted', 'interviewing', 'hired', 'rejected'].includes(action)) {
                    data.status = action;
                }

                return fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Bulk action completed successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to perform action');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage('Error: ' + error.message);
                });
            }
        });
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
