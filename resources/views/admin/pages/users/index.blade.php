{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Users - Admin Panel')
@section('page-title', 'Users Management')

@section('content')
<div class="space-y-6">
    
    <!-- ===== HEADER WITH STATS ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
            <p class="text-sm text-gray-500">Manage all registered users</p>
        </div>
        <a href="{{ route('users.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add User
        </a>
    </div>
    
    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Active</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['active'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Pending</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['pending'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Suspended</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['suspended'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Verified</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['verified'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Unverified</p>
            <p class="text-2xl font-bold text-gray-600 mt-1">{{ $stats['unverified'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Trashed</p>
                <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['trashed'] ?? 0 }}</p>
            </div>
    </div>
    
    <!-- ===== FILTERS & SEARCH ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name, email, phone..." 
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>
            
            <!-- Filter: User Type -->
            <div class="w-36">
                <select name="user_type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Types</option>
                    <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="employer" {{ request('user_type') == 'employer' ? 'selected' : '' }}>Employer</option>
                    <option value="recruiter" {{ request('user_type') == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                    <option value="job_seeker" {{ request('user_type') == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                </select>
            </div>
            
            <!-- Filter: Status -->
            <div class="w-36">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            
            <!-- Filter: Verification -->
            <div class="w-36">
                <select name="verification" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All</option>
                    <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="unverified" {{ request('verification') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                </select>
            </div>

            <!-- Filter: Trashed -->
            <div class="w-36">
                <select name="trashed" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Records</option>
                    <option value="with" {{ request('trashed') == 'with' ? 'selected' : '' }}>With Trashed</option>
                    <option value="only" {{ request('trashed') == 'only' ? 'selected' : '' }}>Trashed Only</option>
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
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>
    
    <!-- ===== USERS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left w-10">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group {{ $user->trashed() ? 'bg-red-50/30' : '' }}">
                        <!-- Checkbox -->
                        <td class="px-6 py-4">
                            <input type="checkbox" name="selected[]" value="{{ $user->id }}" 
                                   class="user-checkbox rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                        </td>
                        
                        <!-- User -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($user->profile_photo)
                                        <img src="{{ Storage::url($user->profile_photo) }}" 
                                             alt="{{ $user->first_name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-gray-600 text-sm font-medium">
                                            {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-400 truncate max-w-[150px]">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- User Type -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($user->user_type === 'admin') bg-purple-50 text-purple-700
                                @elseif($user->user_type === 'employer') bg-orange-50 text-orange-700
                                @elseif($user->user_type === 'recruiter') bg-blue-50 text-blue-700
                                @else bg-green-50 text-green-700
                                @endif">
                                @if($user->user_type === 'admin')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @elseif($user->user_type === 'employer')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                @elseif($user->user_type === 'recruiter')
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                                {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}
                            </span>
                        </td>
                        
                        <!-- Phone -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $user->phone ?? '—' }}</p>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($user->status === 'active') bg-emerald-50 text-emerald-700
                                @elseif($user->status === 'pending') bg-amber-50 text-amber-700
                                @elseif($user->status === 'suspended') bg-red-50 text-red-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                    @if($user->status === 'active') bg-emerald-500
                                    @elseif($user->status === 'pending') bg-amber-500
                                    @elseif($user->status === 'suspended') bg-red-500
                                    @else bg-gray-500
                                    @endif"></span>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        
                        <!-- Verification -->
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Unverified
                                </span>
                            @endif
                        </td>
                        
                        <!-- Joined -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if($user->trashed())
                                    <button onclick="restoreUser({{ $user->id }})" 
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200"
                                            title="Restore">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.418 0V4h-.582m-15.418 0a9 9 0 1118 0m-18 0a9 9 0 01-3.6 6.6m18-6.6a9 9 0 01-3.6 6.6"/>
                                        </svg>
                                    </button>
                                    <button onclick="forceDeleteUser({{ $user->id }})" 
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                            title="Permanently Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    <form id="restore-form-{{ $user->id }}" 
                                        action="{{ route('users.restore', $user->id) }}" 
                                        method="POST" class="hidden">
                                        @csrf
                                    </form>
                                    <form id="force-delete-form-{{ $user->id }}" 
                                        action="{{ route('users.force-delete', $user->id) }}" 
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <!-- Existing actions (view, edit, verify, delete) -->
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No users found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filters</p>
                                <a href="{{ route('users.create') }}" class="mt-4 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                                    Add First User
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- ===== TABLE FOOTER ===== -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            <div class="flex flex-wrap items-center gap-4">
                <p class="text-sm text-gray-500">
                    Showing <span class="font-medium text-gray-700">{{ $users->firstItem() ?? 0 }}</span> 
                    to <span class="font-medium text-gray-700">{{ $users->lastItem() ?? 0 }}</span> 
                    of <span class="font-medium text-gray-700">{{ $users->total() }}</span> results
                </p>
                <!-- Bulk Actions -->
                <div class="flex items-center gap-2">
                    <select id="bulkAction" class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                        <option value="active">Set Active</option>
                        <option value="pending">Set Pending</option>
                        <option value="suspended">Set Suspended</option>
                        <option value="verify">Verify Email</option>
                    </select>
                    <button id="applyBulkAction" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-all">
                        Apply
                    </button>
                </div>
            </div>
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ===== CONFIRM DELETE =====
    function confirmDelete(id) {
    Swal.fire({
        title: 'Move to Trash?',
        text: 'This user will be moved to trash. You can restore it later.',
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

    function forceDeleteUser(id) {
    Swal.fire({
        title: 'Permanently Delete?',
        html: `
            <div class="text-left">
                <p class="text-red-600 font-semibold">⚠️ Warning: This action cannot be undone!</p>
                <p class="text-sm text-gray-500 mt-2">This user will be permanently deleted from the database</p>
                <ul class="text-sm text-gray-500 mt-2 list-disc list-inside">
                    <li>All personal data will be removed</li>
                    <li>Profile photo will be deleted</li>
                    <li>This action is irreversible</li>
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

    // ===== VERIFY USER =====
    function verifyUser(id) {
        if (confirm('Verify this user\'s email address?')) {
            document.getElementById('verify-form-' + id).submit();
        }
    }

    // ===== SELECT ALL =====
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // ===== BULK ACTIONS =====
    document.getElementById('applyBulkAction')?.addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        const selected = document.querySelectorAll('.user-checkbox:checked');
        
        if (!action) {
            alert('Please select an action');
            return;
        }
        
        if (selected.length === 0) {
            alert('Please select at least one user');
            return;
        }
        
        const ids = Array.from(selected).map(cb => cb.value);
        
        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${selected.length} user(s)?`)) {
                return;
            }
            
            fetch('{{ route("users.bulk-delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        } else {
            // Bulk status update
            fetch('{{ route("users.bulk-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: ids, status: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    });
</script>

@endsection