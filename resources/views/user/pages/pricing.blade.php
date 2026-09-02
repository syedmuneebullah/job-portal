@extends('user.layouts.app')
@section('content')

<main class="bg-white min-h-screen py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== HEADER ===== -->
        <div class="text-center mb-16">
            <span class="inline-block text-xs font-semibold text-[#FF7543] bg-[#FF7543]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                Pricing Plans
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-[#1a237e] leading-tight mb-4">
                Choose Your <span class="text-[#FF7543]">Path</span>
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                Basic is always free. Career+ unlocks when billing is enabled for your workspace.
            </p>
        </div>

        <!-- ===== PRICING GRID ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            
            @forelse($plans as $index => $plan)
                @php
                    $isPopular = $index == 1 && count($plans) > 2;
                    $isFree = $plan->price == 0;
                    $features = $plan->features_list ?? [];
                @endphp

                @if($isPopular)
                    <!-- ===== POPULAR PLAN (DARK BACKGROUND) ===== -->
                    <div class="relative bg-[#1a237e] rounded-3xl p-8 flex flex-col shadow-2xl shadow-[#1a237e]/30 transform lg:scale-105 z-10">
                        <!-- Most Popular Badge -->
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#FF7543] text-white text-xs font-bold px-6 py-1.5 rounded-full shadow-lg shadow-[#FF7543]/30">
                            MOST POPULAR
                        </div>

                        <div class="mb-8 mt-4">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                            <p class="text-blue-200 text-sm mb-6">{{ $plan->description ?? 'For individuals just starting out' }}</p>
                            
                            <div class="flex items-baseline gap-1">
                                @if($isFree)
                                    <span class="text-5xl font-extrabold text-white">$0</span>
                                @else
                                    <span class="text-5xl font-extrabold text-white">${{ number_format($plan->price) }}</span>
                                @endif
                                <span class="text-blue-200 font-medium">/{{ $plan->billing_period_label }}</span>
                            </div>
                        </div>

                        <ul class="space-y-4 mb-8 flex-1">
                            @if(!empty($features))
                                @foreach($features as $feature)
                                    <li class="flex items-start gap-3 text-sm text-blue-100">
                                        <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-3 text-sm text-blue-100">
                                    <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                                    Basic features included
                                </li>
                                <li class="flex items-start gap-3 text-sm text-blue-100">
                                    <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                                    Standard support
                                </li>
                            @endif
                        </ul>

                        <div class="bg-white/10 border border-white/20 rounded-xl p-3 mb-6">
                            <p class="text-xs font-semibold text-blue-100 text-center">
                                <i class="fas fa-info-circle mr-1"></i> {{ $isFree ? 'No billing required' : 'Needs billing enabled' }}
                            </p>
                        </div>

                        <button onclick="subscribeToPlan({{ $plan->id }}, '{{ $plan->name }}')" 
                                class="w-full py-3.5 bg-[#FF7543] hover:bg-[#E65C00] text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#FF7543]/30">
                            {{ $isFree ? 'Continue Free' : 'See notice above' }}
                        </button>
                    </div>
                @else
                    <!-- ===== REGULAR PLAN (WHITE BACKGROUND) ===== -->
                    <div class="group relative bg-white rounded-3xl border-2 border-gray-100 p-8 flex flex-col shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-[#1a237e] mb-2">{{ $plan->name }}</h3>
                            <p class="text-sm text-gray-500 mb-6">{{ $plan->description ?? 'For your needs' }}</p>
                            
                            <div class="flex items-baseline gap-1">
                                @if($isFree)
                                    <span class="text-5xl font-extrabold text-[#1a237e]">$0</span>
                                @else
                                    <span class="text-5xl font-extrabold text-[#1a237e]">${{ number_format($plan->price) }}</span>
                                @endif
                                <span class="text-gray-400 font-medium">/{{ $plan->billing_period_label }}</span>
                            </div>
                        </div>

                        <ul class="space-y-4 mb-8 flex-1">
                            @if(!empty($features))
                                @foreach($features as $feature)
                                    <li class="flex items-start gap-3 text-sm text-gray-600">
                                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                    Basic features included
                                </li>
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                    Standard support
                                </li>
                            @endif
                        </ul>

                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 mb-6">
                            <p class="text-xs font-semibold text-gray-500 text-center">
                                <i class="fas fa-info-circle mr-1"></i> {{ $isFree ? 'No billing required' : 'Needs billing enabled' }}
                            </p>
                        </div>

                        <button onclick="subscribeToPlan({{ $plan->id }}, '{{ $plan->name }}')" 
                                class="w-full py-3.5 {{ $isFree ? 'bg-gray-100 hover:bg-gray-200 text-[#1a237e]' : 'bg-[#1a237e] hover:bg-[#0d1445] text-white' }} font-bold rounded-xl transition-all duration-300 {{ !$isFree ? 'shadow-lg shadow-[#1a237e]/20' : '' }}">
                            {{ $isFree ? 'Continue Free' : 'See notice above' }}
                        </button>
                    </div>
                @endif
            @empty
                <!-- ===== NO PLANS AVAILABLE ===== -->
                <div class="col-span-full text-center py-12">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">No subscription plans available</p>
                        <p class="text-gray-400 text-sm mt-1">Please check back later for our pricing plans.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- ===== FOOTER NOTE ===== -->
        <div class="text-center mt-12">
            <p class="text-sm text-gray-500">
                <i class="fas fa-shield-alt text-[#FF7543] mr-1"></i>
                All plans include a 14-day money-back guarantee. No questions asked.
            </p>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ===== SUBSCRIBE TO PLAN =====
    function subscribeToPlan(planId, planName) {
        Swal.fire({
            title: 'Subscribe to ' + planName + '?',
            text: 'You are about to subscribe to this plan. Would you like to continue?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('/subscribe', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ plan_id: planId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'You have been subscribed successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                location.reload();
                            }
                        });
                    } else {
                        throw new Error(data.message || 'Failed to subscribe');
                    }
                })
                .catch(error => {
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }
</script>

@endsection