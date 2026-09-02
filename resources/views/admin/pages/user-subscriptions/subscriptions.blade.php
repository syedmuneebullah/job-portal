@extends('admin.layouts.app')

@section('title', 'User Subscriptions - Admin Panel')
@section('page-title', 'User Subscriptions')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All User Subscriptions</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm">
                <a href="{{ route('admin.subscriptions.index') }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ !request('status') ? 'text-[#1a237e] font-medium' : '' }}">
                    All <span class="font-semibold">{{ $stats['total'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'active' ? 'text-[#1a237e] font-medium' : '' }}">
                    Active <span class="font-semibold">{{ $stats['active'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trial']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'trial' ? 'text-[#1a237e] font-medium' : '' }}">
                    Trial <span class="font-semibold">{{ $stats['trial'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'expired']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'expired' ? 'text-[#1a237e] font-medium' : '' }}">
                    Expired <span class="font-semibold">{{ $stats['expired'] ?? 0 }}</span>
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}"
                   class="text-gray-600 hover:text-[#1a237e] transition-colors whitespace-nowrap {{ request('status') == 'cancelled' ? 'text-[#1a237e] font-medium' : '' }}">
                    Cancelled <span class="font-semibold">{{ $stats['cancelled'] ?? 0 }}</span>
                </a>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href=""
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </a>
        </div>
    </div>

    <!-- ===== FILTERS ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by user or plan..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                </div>
            </div>

            <!-- Filter: Status -->
            <div class="w-32">
                <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter: Plan -->
            <div class="w-40">
                <select name="plan_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
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
                <a href="{{ route('admin.subscriptions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== SUBSCRIPTIONS TABLE ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trial Ends</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subscriptions as $subscription)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        
                        <!-- User -->
                        <td class="px-6 py-4">
                            <div class="space-y-0.5">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $subscription->user?->first_name ?? 'N/A' }} {{ $subscription->user?->last_name ?? '' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $subscription->user?->email ?? 'N/A' }}</p>
                            </div>
                        </td>

                        <!-- Plan -->
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-800">{{ $subscription->plan?->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $subscription->plan?->formatted_price ?? 'Free' }}
                            </p>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @if($subscription->status === 'active') bg-emerald-50 text-emerald-700
                                @elseif($subscription->status === 'trial') bg-blue-50 text-blue-700
                                @elseif($subscription->status === 'expired') bg-red-50 text-red-700
                                @elseif($subscription->status === 'cancelled') bg-amber-50 text-amber-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    @if($subscription->status === 'active') bg-emerald-500
                                    @elseif($subscription->status === 'trial') bg-blue-500
                                    @elseif($subscription->status === 'expired') bg-red-500
                                    @elseif($subscription->status === 'cancelled') bg-amber-500
                                    @else bg-gray-500
                                    @endif"></span>
                                {{ ucfirst($subscription->status) }}
                            </span>
                            @if($subscription->status === 'trial' && $subscription->trial_ends_at)
                                @php
                                    $remainingDays = ceil($subscription->remaining_trial_days);
                                @endphp
                                @if($remainingDays > 0)
                                    <span class="block text-[10px] text-blue-600 mt-0.5">
                                        {{ $remainingDays }} day{{ $remainingDays > 1 ? 's' : '' }} left
                                    </span>
                                @else
                                    <span class="block text-[10px] text-red-600 mt-0.5">
                                        Trial expired
                                    </span>
                                @endif
                            @endif
                        </td>

                        <!-- Trial Ends -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">
                                {{ $subscription->trial_ends_at?->format('M d, Y') ?? 'N/A' }}
                            </p>
                            
                        </td>

                        <!-- Expires At -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">
                                {{ $subscription->ends_at?->format('M d, Y') ?? 'N/A' }}
                            </p>
                            @if($subscription->ends_at)
                                <p class="text-xs text-gray-400">
                                    {{ $subscription->ends_at->diffForHumans() }}
                                </p>
                            @endif
                        </td>

                        <!-- Created -->
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-700">{{ $subscription->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $subscription->created_at->diffForHumans() }}</p>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.subscriptions.show', $subscription->id) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                   title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                @if($subscription->status === 'active' || $subscription->status === 'trial')
                                    <button onclick="cancelSubscription({{ $subscription->id }})"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                                            title="Cancel Subscription">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                @endif
                                
                                @if($subscription->status === 'expired' || $subscription->status === 'cancelled')
                                    <button onclick="activateSubscription({{ $subscription->id }})"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200"
                                            title="Activate Subscription">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                @endif
                                
                                <button onclick="extendSubscription({{ $subscription->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-all duration-200"
                                        title="Extend Subscription">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>

                                <!-- Hidden Forms -->
                                <form id="cancel-form-{{ $subscription->id }}"
                                    action="{{ route('admin.subscriptions.cancel', $subscription->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                </form>
                                
                                <form id="activate-form-{{ $subscription->id }}"
                                    action="{{ route('admin.subscriptions.activate', $subscription->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                </form>
                                
                                <form id="extend-form-{{ $subscription->id }}"
                                    action="{{ route('admin.subscriptions.extend', $subscription->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="days" id="extendDaysInput">
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
                                <p class="text-gray-500 font-medium">No subscriptions found</p>
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
            <div class="flex flex-wrap items-center gap-4">
                <p class="text-sm text-gray-500">
                    Showing <span class="font-medium text-gray-700">{{ $subscriptions->firstItem() ?? 0 }}</span>
                    to <span class="font-medium text-gray-700">{{ $subscriptions->lastItem() ?? 0 }}</span>
                    of <span class="font-medium text-gray-700">{{ $subscriptions->total() }}</span> results
                </p>
                
            </div>
            {{ $subscriptions->withQueryString()->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ===== SELECT ALL =====
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.subscription-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // ===== CANCEL SUBSCRIPTION =====
    function cancelSubscription(id) {
        Swal.fire({
            title: 'Cancel Subscription?',
            text: 'This user will lose access to premium features.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                document.getElementById('cancel-form-' + id).submit();
            }
        });
    }

    // ===== ACTIVATE SUBSCRIPTION =====
    function activateSubscription(id) {
        Swal.fire({
            title: 'Activate Subscription?',
            text: 'This user will gain access to premium features.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, activate it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                document.getElementById('activate-form-' + id).submit();
            }
        });
    }

    // ===== EXTEND SUBSCRIPTION =====
    function extendSubscription(id) {
        Swal.fire({
            title: 'Extend Subscription',
            html: `
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter number of days to extend:</label>
                    <input type="number" id="extendDays" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all" 
                           placeholder="e.g. 30" min="1" max="3650" value="30">
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Extend',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                const days = document.getElementById('extendDays').value;
                if (!days || days < 1) {
                    Swal.showValidationMessage('Please enter a valid number of days');
                    return;
                }
                document.getElementById('extendDaysInput').value = days;
                document.getElementById('extend-form-' + id).submit();
            }
        });
    }

    // ===== BULK ACTIONS =====
    document.getElementById('applyBulkAction')?.addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        const selected = document.querySelectorAll('.subscription-checkbox:checked');

        if (!action) {
            Swal.fire('Error', 'Please select an action', 'error');
            return;
        }

        if (selected.length === 0) {
            Swal.fire('Error', 'Please select at least one subscription', 'error');
            return;
        }

        const ids = Array.from(selected).map(cb => cb.value);
        const count = selected.length;

        Swal.fire({
            title: `Bulk ${action}?`,
            text: `You are about to ${action} ${count} subscription(s).`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Yes, ${action} them!`,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                return fetch(`/admin/subscriptions/bulk-update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ids: ids,
                        status: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || `${count} subscription(s) updated.`,
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
            }
        });
    });
</script>

@endsection