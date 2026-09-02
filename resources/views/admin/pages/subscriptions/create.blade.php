@extends('admin.layouts.app')

@section('title', isset($plan) ? 'Edit Plan - Admin Panel' : 'Create Plan - Admin Panel')
@section('page-title', isset($plan) ? 'Edit Subscription Plan' : 'Create Subscription Plan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl mx-auto">
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="font-medium">Please fix the following errors:</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ isset($plan) ? route('admin.subscription-plans.update', $plan->id) : route('admin.subscription-plans.store') }}"
          method="POST"
          class="space-y-6">
        @csrf
        @if(isset($plan))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div class="border-b border-gray-200 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Plan Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $plan->name ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('name') border-red-500 @enderror"
                           placeholder="e.g. Premium Plan" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('description') border-red-500 @enderror"
                              placeholder="Plan description...">{{ old('description', $plan->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target User Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Target User Type <span class="text-red-500">*</span></label>
                    <select name="target_user_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('target_user_type') border-red-500 @enderror" required>
                        <option value="">Select User Type</option>
                        @foreach($userTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('target_user_type', $plan->target_user_type ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('target_user_type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('sort_order') border-red-500 @enderror"
                           placeholder="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="border-b border-gray-200 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Price <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $plan->price ?? 0) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('price') border-red-500 @enderror"
                           placeholder="0.00" min="0" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency <span class="text-red-500">*</span></label>
                    <select name="currency" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('currency') border-red-500 @enderror" required>
                        <option value="USD" {{ old('currency', $plan->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ old('currency', $plan->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="GBP" {{ old('currency', $plan->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Billing Period -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Billing Period <span class="text-red-500">*</span></label>
                    <select name="billing_period" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('billing_period') border-red-500 @enderror" required>
                        <option value="">Select Period</option>
                        @foreach($billingPeriods as $key => $label)
                            <option value="{{ $key }}" {{ old('billing_period', $plan->billing_period ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('billing_period')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trial Days -->
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Trial Days</label>
                    <input type="number" name="trial_days" value="{{ old('trial_days', $plan->trial_days ?? 0) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('trial_days') border-red-500 @enderror"
                           placeholder="0 (no trial)" min="0">
                    @error('trial_days')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="border-b border-gray-200 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Features</h3>
            <div id="features-container" class="space-y-2">
                @php
                    $features = old('features', isset($plan) ? $plan->features_list : []);
                    if (empty($features)) $features = [''];
                @endphp
                @foreach($features as $index => $feature)
                    <div class="flex items-center gap-2 feature-item">
                        <input type="text" name="features[]" value="{{ $feature }}"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                               placeholder="e.g. Unlimited Job Postings">
                        <button type="button" class="remove-feature p-2 text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-feature" class="mt-2 text-sm text-[#1a237e] hover:underline">
                + Add Feature
            </button>
            @error('features')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Limits -->
        <div class="border-b border-gray-200 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Limits</h3>
            <div id="limits-container" class="space-y-2">
                @php
                    $limits = old('limits', isset($plan) ? $plan->limits_list : []);
                    if (empty($limits)) $limits = [''];
                @endphp
                @foreach($limits as $index => $limit)
                    <div class="flex items-center gap-2 limit-item">
                        <input type="text" name="limits[]" value="{{ $limit }}"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                               placeholder="e.g. Max 50 Applications per month">
                        <button type="button" class="remove-limit p-2 text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-limit" class="mt-2 text-sm text-[#1a237e] hover:underline">
                + Add Limit
            </button>
            @error('limits')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', isset($plan) ? $plan->is_active : true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e] w-5 h-5">
                <span class="text-sm text-gray-700 font-medium">Active</span>
                <span class="text-xs text-gray-400">(Plan will be available for subscription)</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
            <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                {{ isset($plan) ? 'Update Plan' : 'Create Plan' }}
            </button>
            <a href="{{ route('admin.subscription-plans.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Feature
        document.getElementById('add-feature')?.addEventListener('click', function() {
            const container = document.getElementById('features-container');
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center gap-2 feature-item';
            newItem.innerHTML = `
                <input type="text" name="features[]" value=""
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Unlimited Job Postings">
                <button type="button" class="remove-feature p-2 text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
            attachFeatureRemoveListener(newItem.querySelector('.remove-feature'));
        });

        // Add Limit
        document.getElementById('add-limit')?.addEventListener('click', function() {
            const container = document.getElementById('limits-container');
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center gap-2 limit-item';
            newItem.innerHTML = `
                <input type="text" name="limits[]" value=""
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                       placeholder="e.g. Max 50 Applications per month">
                <button type="button" class="remove-limit p-2 text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
            attachLimitRemoveListener(newItem.querySelector('.remove-limit'));
        });

        // Remove Feature
        function attachFeatureRemoveListener(button) {
            button?.addEventListener('click', function() {
                const item = this.closest('.feature-item');
                const container = item.parentElement;
                if (container.children.length > 1) {
                    item.remove();
                } else {
                    alert('You must have at least one feature field.');
                }
            });
        }

        // Remove Limit
        function attachLimitRemoveListener(button) {
            button?.addEventListener('click', function() {
                const item = this.closest('.limit-item');
                const container = item.parentElement;
                if (container.children.length > 1) {
                    item.remove();
                } else {
                    alert('You must have at least one limit field.');
                }
            });
        }

        // Attach listeners to existing remove buttons
        document.querySelectorAll('.remove-feature').forEach(btn => attachFeatureRemoveListener(btn));
        document.querySelectorAll('.remove-limit').forEach(btn => attachLimitRemoveListener(btn));
    });
</script>

@endsection