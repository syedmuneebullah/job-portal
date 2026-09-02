@extends('employer.layouts.app')

@section('title', 'Jobs - Admin Panel')
@section('page-title', 'Jobs Management')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER WITH STATS (WordPress Style) ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Jobs</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                <!-- All Jobs -->
                <span class="text-gray-600 whitespace-nowrap">
                    All <span class="font-semibold text-gray-900">{{ $stats['total'] ?? 0 }}</span>
                </span>
                <span class="text-gray-300">|</span>

                <!-- Published -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'published']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'published' ? 'text-[#1a237e] font-medium' : '' }}">
                    Published <span class="font-semibold {{ request('status') == 'published' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['published'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Draft -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'draft']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'draft' ? 'text-[#1a237e] font-medium' : '' }}">
                    Draft <span class="font-semibold {{ request('status') == 'draft' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['draft'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Archived -->
                <a href="{{ request()->fullUrlWithQuery(['status' => 'archived']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'archived' ? 'text-[#1a237e] font-medium' : '' }}">
                    Archived <span class="font-semibold {{ request('status') == 'archived' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['archived'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- Active -->
                <a href="{{ request()->fullUrlWithQuery(['is_active' => '1']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('is_active') == '1' ? 'text-[#1a237e] font-medium' : '' }}">
                    Active <span class="font-semibold {{ request('is_active') == '1' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['active'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>

                <!-- AI Generated -->
                <a href="{{ request()->fullUrlWithQuery(['is_ai_generated' => '1']) }}"
                   class="text-gray-600 hover:text-purple-600 transition-colors whitespace-nowrap {{ request('is_ai_generated') == '1' ? 'text-purple-600 font-medium' : '' }}">
                    AI <span class="font-semibold {{ request('is_ai_generated') == '1' ? 'text-purple-600' : 'text-gray-900' }}">{{ $stats['ai_generated'] ?? 0 }}</span>
                </a>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href=""
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </a>
            <a href="{{ route('employer.jobs.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Job
            </a>
        </div>
    </div>

    <!-- ===== FILTERS & SEARCH ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('employer.jobs.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search jobs..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: Status -->
            <div class="w-full sm:w-32">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <!-- Filter: Work Type -->
            <div class="w-full sm:w-32">
                <select name="work_type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">Work Type</option>
                    <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                    <option value="onsite" {{ request('work_type') == 'onsite' ? 'selected' : '' }}>Onsite</option>
                    <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>

            <!-- Filter: Employment Type -->
            <div class="w-full sm:w-32">
                <select name="employment_type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">Employment</option>
                    <option value="full_time" {{ request('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time" {{ request('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="freelance" {{ request('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                </select>
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
                <a href="{{ route('employer.jobs.index') }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== JOBS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left w-10">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Salary</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Applications</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <!-- Checkbox -->
                        <td class="px-4 py-4">
                            <input type="checkbox" name="selected[]" value="{{ $job->id }}"
                                   class="job-checkbox rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </td>

                        <!-- Job Details -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-900 hover:text-[#1a237e] transition-colors">
                                    {{ $job->title }}
                                </p>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ Str::limit($job->location, 20) }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300 hidden sm:block"></span>
                                    <span class="flex items-center gap-1 hidden sm:flex">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $job->department ?? 'N/A' }}
                                    </span>
                                    @if($job->is_ai_generated)
                                        <span class="px-1.5 py-0.5 bg-purple-50 text-purple-600 text-[10px] rounded-full">AI</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Type -->
                        <td class="px-4 py-4 hidden md:table-cell">
                            <div class="space-y-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($job->work_type === 'remote') bg-blue-50 text-blue-700
                                    @elseif($job->work_type === 'hybrid') bg-purple-50 text-purple-700
                                    @else bg-gray-50 text-gray-700
                                    @endif">
                                    {{ ucfirst($job->work_type) }}
                                </span>
                                <br>
                                <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $job->employment_type ?? 'N/A')) }}</span>
                            </div>
                        </td>

                        <!-- Salary -->
                        <td class="px-4 py-4 hidden lg:table-cell">
                            @if($job->salary_min && $job->salary_max)
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $job->currency ?? '$' }}{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                </p>
                            @else
                                <span class="text-sm text-gray-400">Not specified</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($job->status === 'published') bg-emerald-50 text-emerald-700
                                    @elseif($job->status === 'draft') bg-amber-50 text-amber-700
                                    @else bg-gray-50 text-gray-700
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                        @if($job->status === 'published') bg-emerald-500
                                        @elseif($job->status === 'draft') bg-amber-500
                                        @else bg-gray-500
                                        @endif"></span>
                                    {{ ucfirst($job->status) }}
                                </span>
                            </div>
                        </td>

                        <!-- Applications -->
                        <td class="px-4 py-4 hidden sm:table-cell">
                            <p class="text-sm font-medium text-gray-800">{{ $job->applications_count ?? 0 }}</p>
                            <p class="text-xs text-gray-400">applications</p>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('employer.jobs.show', $job->id) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                   title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('employer.jobs.edit', $job->id) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="duplicateJob({{ $job->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-all duration-200"
                                        title="Duplicate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                                <button onclick="toggleStatus({{ $job->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200"
                                        title="{{ $job->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                    @if($job->status === 'published')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                                <button onclick="confirmDelete({{ $job->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $job->id }}" action="" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                                <form id="toggle-status-form-{{ $job->id }}" action="" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <form id="duplicate-form-{{ $job->id }}" action="" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No jobs found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filters</p>
                                <a href="{{ route('employer.jobs.create') }}" class="mt-4 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                                    Create First Job
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
                    Showing <span class="font-medium text-gray-700">{{ $jobs->firstItem() ?? 0 }}</span>
                    to <span class="font-medium text-gray-700">{{ $jobs->lastItem() ?? 0 }}</span>
                    of <span class="font-medium text-gray-700">{{ $jobs->total() }}</span> results
                </p>
                <!-- Bulk Actions -->
                <div class="flex flex-wrap items-center gap-2">
                    <select id="bulkAction" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                        <option value="published">Publish</option>
                        <option value="draft">Move to Draft</option>
                        <option value="archived">Archive</option>
                    </select>
                    <button id="applyBulkAction" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-all">
                        Apply
                    </button>
                </div>
            </div>
            <div class="w-full sm:w-auto">
                {{ $jobs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // ===== CONFIRM DELETE =====
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this job post?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // ===== TOGGLE STATUS =====
    function toggleStatus(id) {
        document.getElementById('toggle-status-form-' + id).submit();
    }

    // ===== DUPLICATE JOB =====
    function duplicateJob(id) {
        if (confirm('Duplicate this job posting?')) {
            document.getElementById('duplicate-form-' + id).submit();
        }
    }

    // ===== SELECT ALL =====
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.job-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // ===== BULK ACTIONS =====
    document.getElementById('applyBulkAction')?.addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        const selected = document.querySelectorAll('.job-checkbox:checked');

        if (!action) {
            alert('Please select an action');
            return;
        }

        if (selected.length === 0) {
            alert('Please select at least one job');
            return;
        }

        if (!confirm(`Are you sure you want to ${action} ${selected.length} job(s)?`)) {
            return;
        }

        const ids = Array.from(selected).map(cb => cb.value);
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);

        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'ids';
        idsInput.value = JSON.stringify(ids);
        form.appendChild(idsInput);

        document.body.appendChild(form);
        form.submit();
    });
</script>

@endsection
