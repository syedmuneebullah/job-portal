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
            
            <!-- ===== BASIC PLAN ===== -->
            <div class="group relative bg-white rounded-3xl border-2 border-gray-100 p-8 flex flex-col shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-[#1a237e] mb-2">Basic</h3>
                    <p class="text-sm text-gray-500 mb-6">For casual checking</p>
                    
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-[#1a237e]">$0</span>
                        <span class="text-gray-400 font-medium">/mo</span>
                    </div>
                </div>

                <ul class="space-y-4 mb-8 flex-1">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        1 AI Resume Build
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Basic Job Matching
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
                        Cover Letter Generator
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
                        Priority Support
                    </li>
                </ul>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 mb-6">
                    <p class="text-xs font-semibold text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i> Needs billing enabled
                    </p>
                </div>

                <button class="w-full py-3.5 bg-gray-100 hover:bg-gray-200 text-[#1a237e] font-bold rounded-xl transition-all duration-300">
                    Continue Free
                </button>
            </div>

            <!-- ===== STARTER PLAN (MOST POPULAR) ===== -->
            <div class="relative bg-[#1a237e] rounded-3xl p-8 flex flex-col shadow-2xl shadow-[#1a237e]/30 transform lg:scale-105 z-10">
                <!-- Most Popular Badge -->
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#FF7543] text-white text-xs font-bold px-6 py-1.5 rounded-full shadow-lg shadow-[#FF7543]/30">
                    MOST POPULAR
                </div>

                <div class="mb-8 mt-4">
                    <h3 class="text-xl font-bold text-white mb-2">Starter</h3>
                    <p class="text-blue-200 text-sm mb-6">For individuals just starting out</p>
                    
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-white">$15</span>
                        <span class="text-blue-200 font-medium">/mo</span>
                    </div>
                </div>

                <ul class="space-y-4 mb-8 flex-1">
                    <li class="flex items-start gap-3 text-sm text-blue-100">
                        <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                        5 AI Resume Builds
                    </li>
                    <li class="flex items-start gap-3 text-sm text-blue-100">
                        <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                        Basic Job Matching
                    </li>
                    <li class="flex items-start gap-3 text-sm text-blue-100">
                        <i class="fas fa-check-circle text-[#FF7543] mt-0.5"></i>
                        Application Tracking
                    </li>
                    <li class="flex items-start gap-3 text-sm text-blue-100">
                        <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
                        Cover Letter Generator
                    </li>
                </ul>

                <div class="bg-white/10 border border-white/20 rounded-xl p-3 mb-6">
                    <p class="text-xs font-semibold text-blue-100 text-center">
                        <i class="fas fa-info-circle mr-1"></i> Needs billing enabled
                    </p>
                </div>

                <button class="w-full py-3.5 bg-[#FF7543] hover:bg-[#E65C00] text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#FF7543]/30">
                    See notice above
                </button>
            </div>

            <!-- ===== PROFESSIONAL PLAN ===== -->
            <div class="group relative bg-white rounded-3xl border-2 border-gray-100 p-8 flex flex-col shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-[#1a237e] mb-2">Professional</h3>
                    <p class="text-sm text-gray-500 mb-6">For serious job seekers</p>
                    
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-[#1a237e]">$30</span>
                        <span class="text-gray-400 font-medium">/mo</span>
                    </div>
                </div>

                <ul class="space-y-4 mb-8 flex-1">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Unlimited AI Resumes
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Priority Matching
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Cover Letter Generator
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Interview AI Practice
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        Email Support
                    </li>
                </ul>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 mb-6">
                    <p class="text-xs font-semibold text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i> Needs billing enabled
                    </p>
                </div>

                <button class="w-full py-3.5 bg-[#1a237e] hover:bg-[#0d1445] text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#1a237e]/20">
                    See notice above
                </button>
            </div>
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

@endsection