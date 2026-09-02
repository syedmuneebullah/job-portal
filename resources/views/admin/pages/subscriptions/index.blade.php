@extends('admin.layouts.app')

@section('title', 'Subscription Plans - Admin Panel')
@section('page-title', 'Subscription Plans')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Plans</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                <a href="{{ route('admin.subscription-plans.index') }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ !request('status') ? 'text-[#1a237e] font-medium' : '' }}">
                    All <span class="font-semibold">{{ $stats['total'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'active' ? 'text-[#1a237e] font-medium' : '' }}">
                    Active <span class="font-semibold">{{ $stats['active'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'inactive' ? 'text-[#1a237e] font-medium' : '' }}">
                    Inactive <span class="font-semibold">{{ $stats['inactive'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['user_type' => 'employer']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('user_type') == 'employer' ? 'text-[#1a237e] font-medium' : '' }}">
                    Employer <span class="font-semibold">{{ $stats['employer'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['user_type' => 'recruiter']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('user_type') == 'recruiter' ? 'text-[#1a237e] font-medium' : '' }}">
                    Recruiter <span class="font-semibold">{{ $stats['recruiter'] ?? 0 }}</span>
                </a>
            </div>
        </div>
        <a href="{{ route('admin.subscription-plans.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Plan
        </a>
    </div>

    <!-- ===== FILTERS ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('admin.subscription-plans.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search plans..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: User Type -->
            <div class="w-40">
                <select name="user_type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Users</option>
                    @foreach($userTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('user_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter: Status -->
            <div class="w-32">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Per Page -->
            <div class="w-24">
                <select name="per_page" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                    Apply Filters
                </button>
                <a href="{{ route('admin.subscription-plans.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== PLANS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscriptions</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($plans as $plan)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <!-- Checkbox -->
                       
                        <!-- Plan Details -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-900 hover:text-[#1a237e] transition-colors">
                                    {{ $plan->name }}
                                </p>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $plan->description ?? 'No description' }}</p>
                                @if($plan->trial_days > 0)
                                    <span class="text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                        {{ $plan->trial_days }} days trial
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- User Type -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($plan->target_user_type === 'employer') bg-blue-50 text-blue-700
                                @elseif($plan->target_user_type === 'recruiter') bg-purple-50 text-purple-700
                                @elseif($plan->target_user_type === 'applicant') bg-green-50 text-green-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                {{ $plan->target_user_type_label }}
                            </span>
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4">
                            @if($plan->is_free)
                                <span class="text-sm font-medium text-emerald-600">Free</span>
                            @else
                                <p class="text-sm font-medium text-gray-800">{{ $plan->formatted_price }}</p>
                            @endif
                        </td>

                        <!-- Billing -->
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $plan->billing_period_label }}</span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($plan->is_active) bg-emerald-50 text-emerald-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    @if($plan->is_active) bg-emerald-500
                                    @else bg-gray-500
                                    @endif"></span>
                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <!-- Subscriptions -->
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-800">{{ $plan->subscriptions_count ?? 0 }}</p>
                            <p class="text-xs text-gray-400">subscribers</p>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.subscription-plans.show', $plan->id) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                   title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                <button onclick="duplicatePlan({{ $plan->id }}, '{{ addslashes($plan->name) }}')"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-all duration-200"
                                        title="Duplicate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                                
                                <button onclick="toggleStatus({{ $plan->id }}, '{{ addslashes($plan->name) }}', {{ $plan->is_active }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200"
                                        title="{{ $plan->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($plan->is_active)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                                
                                <button onclick="confirmDelete({{ $plan->id }}, '{{ addslashes($plan->name) }}')"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                <!-- Hidden Forms -->
                                <form id="delete-form-{{ $plan->id }}"
                                      action="{{ route('admin.subscription-plans.destroy', $plan->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                
                                <form id="toggle-status-form-{{ $plan->id }}"
                                      action="{{ route('admin.subscription-plans.toggle-status', $plan->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                
                                <form id="duplicate-form-{{ $plan->id }}"
                                      action="{{ route('admin.subscription-plans.duplicate', $plan->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No subscription plans found</p>
                                <p class="text-sm text-gray-400 mt-1">Create your first subscription plan</p>
                                <a href="{{ route('admin.subscription-plans.create') }}" class="mt-4 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                                    Create Plan
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
                    Showing <span class="font-medium text-gray-700">{{ $plans->firstItem() ?? 0 }}</span>
                    to <span class="font-medium text-gray-700">{{ $plans->lastItem() ?? 0 }}</span>
                    of <span class="font-medium text-gray-700">{{ $plans->total() }}</span> results
                </p>
               
            </div>
            {{ $plans->withQueryString()->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ===== CONFIRM DELETE =====
    function confirmDelete(id, name = null) {
        const planName = name || 'this subscription plan';
        
        Swal.fire({
            title: 'Delete Subscription Plan?',
            html: `You are about to delete <strong>"${planName}"</strong>.<br>This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                document.getElementById('delete-form-' + id).submit();
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== TOGGLE STATUS =====
    function toggleStatus(id, name = null, currentStatus) {
        const planName = name || 'this plan';
        const action = currentStatus == 1 ? 'deactivate' : 'activate';
        const icon = currentStatus == 1 ? 'warning' : 'success';
        const confirmColor = currentStatus == 1 ? '#eab308' : '#22c55e';
        
        Swal.fire({
            title: `${action === 'activate' ? 'Activate' : 'Deactivate'} Plan?`,
            html: `You are about to ${action} <strong>"${planName}"</strong>.`,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Yes, ${action} it!`,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                document.getElementById('toggle-status-form-' + id).submit();
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== DUPLICATE PLAN =====
    function duplicatePlan(id, name = null) {
        const planName = name || 'this plan';
        
        Swal.fire({
            title: 'Duplicate Plan?',
            html: `You are about to create a duplicate of <strong>"${planName}"</strong>.`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, duplicate it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                document.getElementById('duplicate-form-' + id).submit();
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    // ===== SELECT ALL =====
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.plan-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // ===== BULK ACTIONS =====
    document.getElementById('applyBulkAction')?.addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        const selected = document.querySelectorAll('.plan-checkbox:checked');

        if (!action) {
            Swal.fire({
                title: 'Error',
                text: 'Please select an action',
                icon: 'error',
                confirmButtonColor: '#1a237e'
            });
            return;
        }

        if (selected.length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'Please select at least one plan',
                icon: 'error',
                confirmButtonColor: '#1a237e'
            });
            return;
        }

        const count = selected.length;
        let title, text, icon, confirmText, confirmColor;

        switch(action) {
            case 'delete':
                title = 'Delete Selected Plans?';
                text = `You are about to delete ${count} plan(s). This cannot be undone!`;
                icon = 'warning';
                confirmText = 'Yes, delete them!';
                confirmColor = '#d33';
                break;
            case 'activate':
                title = 'Activate Selected Plans?';
                text = `You are about to activate ${count} plan(s).`;
                icon = 'success';
                confirmText = 'Yes, activate them!';
                confirmColor = '#22c55e';
                break;
            case 'deactivate':
                title = 'Deactivate Selected Plans?';
                text = `You are about to deactivate ${count} plan(s).`;
                icon = 'warning';
                confirmText = 'Yes, deactivate them!';
                confirmColor = '#eab308';
                break;
            default:
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
                const ids = Array.from(selected).map(cb => cb.value);
                let url = '';
                let body = { ids: ids };

                if (action === 'delete') {
                    url = '{{ route("admin.subscription-plans.bulk-delete") }}';
                } else {
                    url = '{{ route("admin.subscription-plans.bulk-status") }}';
                    body.status = action === 'activate' ? 1 : 0;
                }

                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(body)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || `${count} plan(s) updated successfully.`,
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
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
</script>

@endsection