{{-- resources/views/admin/employers/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Employers - Admin Panel')
@section('page-title', 'Employers Management')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER WITH STATS ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Employers</h2>
            <p class="text-sm text-gray-500">Manage all registered employers</p>
        </div>
        <a href=""
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Employer
        </a>
    </div>

   <div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-3 mt-1 text-sm">
            <!-- All Employers -->
            <span class="text-gray-600">
                All <span class="font-semibold text-gray-900">{{ $stats['total'] ?? 0 }}</span>
            </span>
            <span class="text-gray-300">|</span>

            <!-- Active -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-[#1a237e] transition-colors {{ request('status') == 'active' ? 'text-[#1a237e] font-medium' : '' }}">
                Active <span class="font-semibold {{ request('status') == 'active' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['active'] ?? 0 }}</span>
            </a>
            <span class="text-gray-300">|</span>

            <!-- Verified -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-[#1a237e] transition-colors {{ request('verification') == 'verified' ? 'text-[#1a237e] font-medium' : '' }}">
                Verified <span class="font-semibold {{ request('verification') == 'verified' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['verified'] ?? 0 }}</span>
            </a>
            <span class="text-gray-300">|</span>

            <!-- Pending -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-[#1a237e] transition-colors {{ request('status') == 'pending' ? 'text-[#1a237e] font-medium' : '' }}">
                Pending <span class="font-semibold {{ request('status') == 'pending' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['pending'] ?? 0 }}</span>
            </a>
            <span class="text-gray-300">|</span>

            <!-- Suspended -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-[#1a237e] transition-colors {{ request('status') == 'suspended' ? 'text-[#1a237e] font-medium' : '' }}">
                Suspended <span class="font-semibold {{ request('status') == 'suspended' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['suspended'] ?? 0 }}</span>
            </a>
            <span class="text-gray-300">|</span>

            <!-- Rejected -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-[#1a237e] transition-colors {{ request('status') == 'rejected' ? 'text-[#1a237e] font-medium' : '' }}">
                Rejected <span class="font-semibold {{ request('status') == 'rejected' ? 'text-[#1a237e]' : 'text-gray-900' }}">{{ $stats['rejected'] ?? 0 }}</span>
            </a>
            <span class="text-gray-300">|</span>

            <!-- Trashed -->
            <a href="javascript:;"
               class="text-gray-600 hover:text-red-600 transition-colors {{ request('trashed') == 'only' ? 'text-red-600 font-medium' : '' }}">
                Trashed <span class="font-semibold {{ request('trashed') == 'only' ? 'text-red-600' : 'text-gray-900' }}">{{ $stats['trashed'] ?? 0 }}</span>
            </a>
        </div>
    </div>
</div>

    <!-- ===== FILTERS & SEARCH ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name, email, company..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: Status -->
            <div class="w-40">
                <select name="verification_status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="verified" {{ request('verification_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('verification_status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Filter: Trashed -->
            <div class="w-32">
                <select name="trashed" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Records</option>
                    <option value="with" {{ request('trashed') == 'with' ? 'selected' : '' }}>With Trashed</option>
                    <option value="only" {{ request('trashed') == 'only' ? 'selected' : '' }}>Trashed Only</option>
                </select>
            </div>



            <!-- Filter: Industry -->
            <div class="w-40">
                <select name="industry" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Industries</option>
                    @foreach($industries ?? [] as $industry)
                        <option value="{{ $industry }}" {{ request('industry') == $industry ? 'selected' : '' }}>
                            {{ $industry }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Per Page -->
            <div class="w-24">
                <select name="per_page" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                    Apply Filters
                </button>
                <a href="" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== EMPLOYERS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Person</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Industry</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($employers as $employer)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group {{ $employer->trashed() ? 'bg-red-50/30' : '' }}">
                        <!-- Checkbox -->
                        <td class="px-6 py-4">
                            <input type="checkbox" name="selected[]" value="{{ $employer->id }}"
                                   class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </td>

                        <!-- Company -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($employer->company_logo)
                                        <img src="{{ asset('storage/'.$employer->company_logo) }}"
                                             alt="{{ $employer->company_name }}"
                                             class="w-8 h-8 object-contain">
                                    @else
                                        <span class="text-gray-400 text-xs font-medium">
                                            {{ strtoupper(substr($employer->company_name ?? $employer->first_name, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $employer->company_name ?? $employer->first_name . ' ' . $employer->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate max-w-[150px]">{{ $employer->email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Contact -->
                        <td class="px-6 py-4">

                            <p class="text-xs text-gray-400">{{ $employer->phone ?? 'No phone' }}</p>
                        </td>

                        <!-- Industry -->
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $employer->industry ?? '—' }}</span>
                        </td>

                        <!-- Verification -->
                        <td class="px-6 py-4">
                            @if($employer->trashed())
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Deleted
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($employer->verification_status === 'verified') bg-blue-50 text-blue-700
                                    @elseif($employer->verification_status === 'pending') bg-amber-50 text-amber-700
                                    @else bg-red-50 text-red-700
                                    @endif">
                                    {{ ucfirst($employer->verification_status ?? 'N/A') }}
                                </span>
                            @endif
                        </td>

                        <!-- Joined -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $employer->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $employer->created_at->diffForHumans() }}</p>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if($employer->trashed())
                                    <!-- Restore Button -->
                                    <button onclick="restoreEmployer({{ $employer->id }})"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200"
                                            title="Restore">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>

                                    <!-- Force Delete Button -->
                                    <button onclick="forceDelete({{ $employer->id }})"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                            title="Permanently Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>

                                    <form id="restore-form-{{ $employer->id }}"
                                        action="{{ route('admin.employers.restore', $employer->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                    </form>
                                    <form id="force-delete-form-{{ $employer->id }}"
                                        action="{{ route('admin.employers.force-delete', $employer->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <!-- View, Edit, Delete Buttons -->
                                    <a href="{{ route('admin.employers.show', $employer->id) }}"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                    title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.employers.edit', $employer->id) }}"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                                    title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $employer->id }}, '{{ addslashes($employer->company_name) }}')"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    <form id="delete-form-{{ $employer->id }}"
                                        action="{{ route('admin.employers.destroy', $employer->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No employers found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filters</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== TABLE FOOTER ===== -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            <p class="text-sm text-gray-500">
                Showing <span class="font-medium text-gray-700">{{ $employers->firstItem() ?? 0 }}</span>
                to <span class="font-medium text-gray-700">{{ $employers->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-gray-700">{{ $employers->total() }}</span> results
            </p>
            {{ $employers->withQueryString()->links() }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ===== CONFIRM DELETE (Soft Delete) =====
function confirmDelete(id, companyName) {
    Swal.fire({
        title: 'Move to Trash?',
        html: `
            <div class="text-left">
                <p>You are about to move <strong>"${companyName}"</strong> to trash</p>
                <p class="text-sm text-gray-500 mt-2">You can restore it later from the trash</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, move to trash',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        preConfirm: () => {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// ===== RESTORE EMPLOYER =====
function restoreEmployer(id) {
    Swal.fire({
        title: 'Restore Company?',
        text: 'This company will be restored from trash',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, restore it',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            document.getElementById('restore-form-' + id).submit();
        }
    });
}

// ===== FORCE DELETE (Permanent) =====
function forceDelete(id) {
    Swal.fire({
        title: 'Permanently Delete?',
        html: `
            <div class="text-left">
                <p class="text-red-600 font-semibold">⚠️ Warning: This action cannot be undone!</p>
                <p class="text-sm text-gray-500 mt-2">This company will be permanently deleted from the database</p>
                <ul class="text-sm text-gray-500 mt-2 list-disc list-inside">
                    <li>All job posts will be permanently deleted</li>
                    <li>All applications will be removed</li>
                    <li>Company logo will be deleted from storage</li>
                </ul>
            </div>
        `,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete permanently',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        preConfirm: () => {
            document.getElementById('force-delete-form-' + id).submit();
        }
    });
}
// Select All functionality
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('input[name="selected[]"]').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>

@endsection
