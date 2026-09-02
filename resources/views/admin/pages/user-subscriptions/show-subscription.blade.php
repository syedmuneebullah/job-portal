@extends('admin.layouts.app')

@section('title', 'Subscription Details - Admin Panel')
@section('page-title', 'Subscription Details')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Subscription #{{ $subscription->id }}</h2>
            <p class="text-sm text-gray-500">
                {{ $subscription->user?->first_name ?? 'N/A' }} {{ $subscription->user?->last_name ?? '' }} • 
                {{ $subscription->user?->email ?? 'N/A' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.subscriptions.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                Back
            </a>
            <a href="{{ route('admin.subscription-plans.edit', $subscription->plan?->id) }}"
               class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                Edit Plan
            </a>
        </div>
    </div>

    <!-- ===== STATUS CARDS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Status</p>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-1
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
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Plan</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ $subscription->plan?->name ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Billing Period</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ $subscription->plan?->billing_period_label ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Price</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ $subscription->plan?->formatted_price ?? 'Free' }}</p>
        </div>
    </div>

    <!-- ===== DETAILS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-4">
            <!-- User Info -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">User Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400">Full Name</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $subscription->user?->first_name ?? 'N/A' }} {{ $subscription->user?->last_name ?? '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ $subscription->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">User Type</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($subscription->user?->user_type ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Registered Since</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $subscription->user?->created_at?->format('M d, Y') ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Plan Details -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Plan Details</h3>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400">Plan Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->plan?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Target User Type</p>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->plan?->target_user_type_label ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Price</p>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->plan?->formatted_price ?? 'Free' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Billing Period</p>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->plan?->billing_period_label ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Trial Days</p>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->plan?->trial_days ?? 0 }} days</p>
                        </div>
                    </div>

                    <!-- Features -->
                    @if($subscription->plan && $subscription->plan->features_list)
                    <div class="mt-3">
                        <p class="text-xs text-gray-400 mb-2">Features</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($subscription->plan->features_list as $feature)
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">{{ $feature }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Subscription Timeline -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Subscription Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Started</p>
                            <p class="text-xs text-gray-500">{{ $subscription->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @if($subscription->trial_ends_at)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Trial Ends</p>
                            <p class="text-xs text-gray-500">{{ $subscription->trial_ends_at->format('M d, Y H:i') }}</p>
                            @if($subscription->trial_remaining_days > 0)
                                <p class="text-xs text-blue-600">{{ $subscription->trial_remaining_days }} days remaining</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($subscription->ends_at)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full {{ $subscription->status === 'expired' ? 'bg-red-500' : 'bg-amber-500' }} mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $subscription->status === 'expired' ? 'Expired' : 'Expires' }}</p>
                            <p class="text-xs text-gray-500">{{ $subscription->ends_at->format('M d, Y H:i') }}</p>
                            @if($subscription->remaining_days > 0)
                                <p class="text-xs text-amber-600">{{ $subscription->remaining_days }} days remaining</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($subscription->status === 'cancelled')
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Cancelled</p>
                            <p class="text-xs text-gray-500">{{ $subscription->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($subscription->status === 'active' || $subscription->status === 'trial')
                        <button onclick="cancelSubscription({{ $subscription->id }})"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-100 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-200 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Cancel Subscription
                        </button>
                    @endif

                    @if($subscription->status === 'expired' || $subscription->status === 'cancelled')
                        <button onclick="activateSubscription({{ $subscription->id }})"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 text-sm font-medium rounded-lg hover:bg-emerald-200 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Activate Subscription
                        </button>
                    @endif

                    <button onclick="extendSubscription({{ $subscription->id }})"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Extend Subscription
                    </button>
                </div>

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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
</script>

@endsection