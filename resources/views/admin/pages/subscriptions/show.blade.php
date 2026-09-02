@extends('admin.layouts.app')

@section('title', $plan->name . ' - Subscription Plan')
@section('page-title', 'Subscription Plan Details')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h2>
            <p class="text-sm text-gray-500">Subscription Plan Details</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
               class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                Edit Plan
            </a>
            <a href="{{ route('admin.subscription-plans.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                Back
            </a>
        </div>
    </div>

    <!-- ===== PLAN STATS CARDS ===== -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Total Subscribers</p>
            <p class="text-2xl font-bold text-[#1a237e] mt-1">{{ $subscriptionStats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Active Subscriptions</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $subscriptionStats['active'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Expired</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $subscriptionStats['expired'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Cancelled</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $subscriptionStats['cancelled'] ?? 0 }}</p>
        </div>
    </div>

    <!-- ===== PLAN DETAILS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Description -->
            @if($plan->description)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Description</h3>
                <p class="text-sm text-gray-600">{{ $plan->description }}</p>
            </div>
            @endif

            <!-- Features -->
            @if($plan->features && count($plan->features_list) > 0)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Features
                </h3>
                <ul class="space-y-2">
                    @foreach($plan->features_list as $feature)
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Limits -->
            @if($plan->limits && count($plan->limits_list) > 0)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Limits
                </h3>
                <ul class="space-y-2">
                    @foreach($plan->limits_list as $limit)
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $limit }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-4">
            <!-- Quick Info -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Info</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Plan Name</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">User Type</p>
                        <p class="text-sm font-medium text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($plan->target_user_type === 'employer') bg-blue-50 text-blue-700
                                @elseif($plan->target_user_type === 'recruiter') bg-purple-50 text-purple-700
                                @elseif($plan->target_user_type === 'applicant') bg-green-50 text-green-700
                                @else bg-gray-50 text-gray-700
                                @endif">
                                {{ $plan->target_user_type_label }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Price</p>
                        <p class="text-sm font-medium text-gray-900">
                            @if($plan->is_free)
                                <span class="text-emerald-600 font-medium">Free</span>
                            @else
                                {{ $plan->formatted_price }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Billing Period</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->billing_period_label }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Trial Days</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->trial_days > 0 ? $plan->trial_days . ' days' : 'No trial' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Status</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium mt-1
                            @if($plan->is_active) bg-emerald-50 text-emerald-700
                            @else bg-gray-50 text-gray-700
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                @if($plan->is_active) bg-emerald-500
                                @else bg-gray-500
                                @endif"></span>
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Sort Order</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->sort_order }}</p>
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Dates</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Created</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Last Updated</p>
                        <p class="text-sm font-medium text-gray-900">{{ $plan->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Plan
                    </a>
                    
                    <button onclick="duplicatePlan({{ $plan->id }}, '{{ addslashes($plan->name) }}')"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Duplicate Plan
                    </button>
                    
                    <button onclick="toggleStatus({{ $plan->id }}, '{{ addslashes($plan->name) }}', {{ $plan->is_active }})"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 {{ $plan->is_active ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' }} text-sm font-medium rounded-lg transition-all">
                        @if($plan->is_active)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Deactivate Plan
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Activate Plan
                        @endif
                    </button>
                    
                    <button onclick="confirmDelete({{ $plan->id }}, '{{ addslashes($plan->name) }}')"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Plan
                    </button>
                </div>

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
</script>

@endsection