@extends('admin.layouts.app')

@section('title', $employer->company_name . ' - Company Profile')
@section('page-title', 'Company Profile')

@section('content')
<div class="space-y-6">
    
    <!-- ===== COMPANY HEADER ===== -->
    <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Cover with Gradient -->
        <div class="relative h-28">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-2xl -ml-24 -mb-24"></div>
            
            <!-- Action Buttons -->
            <div class="absolute top-4 right-4 flex items-center gap-2 z-10">
                <a href="{{ route('admin.employers.edit', $employer->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#1A237E] backdrop-blur-sm hover:bg-[#1A237E] text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Company
                </a>
                <a href="{{ route('admin.employers.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#1A237E] backdrop-blur-sm hover:bg-[#1A237E] text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
        
        <!-- Company Info -->
        <div class="relative px-6 pb-6">
            <!-- Logo -->
            <div class="flex items-end gap-6 -mt-16">
                <div class="relative">
                    <div class="w-28 h-28 rounded-2xl border-4 border-white bg-white shadow-xl overflow-hidden">
                        @if($employer->company_logo)
                            <img src="{{ Storage::url($employer->company_logo) }}" 
                                 alt="{{ $employer->company_name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <span class="text-4xl font-bold text-gray-400">
                                    {{ strtoupper(substr($employer->company_name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    @if($employer->verification_status === 'verified')
                        <span class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></span>
                    @endif
                </div>
                
                <div class="flex-1 pt-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $employer->company_name }}</h2>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm text-gray-500">{{ $employer->user->email ?? 'N/A' }}</span>
                                @if($employer->verified_at)
                                    <span class="inline-flex items-center gap-1 text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Verification Status -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold
                                @if($employer->verification_status === 'verified') bg-emerald-100 text-emerald-700
                                @elseif($employer->verification_status === 'pending') bg-amber-100 text-amber-700
                                @else bg-red-100 text-red-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($employer->verification_status === 'verified') bg-emerald-500
                                    @elseif($employer->verification_status === 'pending') bg-amber-500
                                    @else bg-red-500
                                    @endif"></span>
                                {{ ucfirst($employer->verification_status) }}
                            </span>
                            
                            <!-- Industry -->
                            @if($employer->industry)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $employer->industry }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="flex flex-wrap items-center gap-4 mt-3">
                        @if($employer->user->phone)
                            <span class="flex items-center gap-1.5 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $employer->user->phone }}
                            </span>
                        @endif
                        @if($employer->website)
                            <span class="flex items-center gap-1.5 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                                </svg>
                                <a href="{{ $employer->website }}" target="_blank" class="text-[#1a237e] hover:underline">{{ $employer->website }}</a>
                            </span>
                        @endif
                        <span class="flex items-center gap-1.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Joined {{ $employer->created_at->format('M d, Y') }}
                        </span>
                        <span class="flex items-center gap-1.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $employer->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-[#1a237e]/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Jobs</p>
            <p class="text-2xl font-bold text-gray-900 mt-1 group-hover:text-[#1a237e] transition-colors">{{ $stats['total_jobs'] ?? 0 }}</p>
            <div class="w-full h-0.5 bg-gray-100 mt-2 rounded-full overflow-hidden">
                <div class="h-full bg-[#1a237e] rounded-full" style="width: {{ min(($stats['total_jobs'] ?? 0) * 10, 100) }}%"></div>
            </div>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-emerald-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Active Jobs</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['active_jobs'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-blue-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Applications</p>
            <p class="text-2xl font-bold text-blue-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['total_applications'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-amber-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Pending</p>
            <p class="text-2xl font-bold text-amber-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['pending_applications'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-purple-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Shortlisted</p>
            <p class="text-2xl font-bold text-purple-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['shortlisted_applications'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-emerald-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Hired</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['hired_applications'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-red-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Rejected</p>
            <p class="text-2xl font-bold text-red-600 mt-1 group-hover:scale-105 transition-transform">{{ $stats['rejected_applications'] ?? 0 }}</p>
        </div>
        
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-5 border border-gray-100 hover:border-gray-500/20">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Company Since</p>
            <p class="text-lg font-bold text-gray-900 mt-1">{{ $employer->created_at->format('M Y') }}</p>
        </div>
    </div>
    
    <!-- ===== RECENT ACTIVITY ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Jobs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-orange-50 rounded-xl">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Recent Jobs</h3>
                </div>
                <a href="#" class="text-xs font-medium text-[#1a237e] hover:underline flex items-center gap-1">
                    View all
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="p-4 space-y-3">
                @forelse($employer->jobs as $job)
                    <div class="group flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 group-hover:bg-orange-50 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 group-hover:text-[#1a237e] transition-colors">{{ $job->title }}</p>
                                <p class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            @if($job->status === 'published') bg-emerald-100 text-emerald-700
                            @elseif($job->status === 'draft') bg-amber-100 text-amber-700
                            @else bg-gray-100 text-gray-600
                            @endif">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">No jobs posted yet</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Company Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-purple-50 rounded-xl">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">Company Details</h3>
                </div>
            </div>
            <div class="p-4 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Company Name</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->company_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Industry</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->industry ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Company Size</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->company_size ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Founded</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->founded_year ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Headquarters</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->headquarters ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Verification Status</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        @if($employer->verification_status === 'verified') bg-emerald-100 text-emerald-700
                        @elseif($employer->verification_status === 'pending') bg-amber-100 text-amber-700
                        @else bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($employer->verification_status) }}
                    </span>
                </div>
                @if($employer->verified_at)
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Verified At</span>
                    <span class="text-sm font-medium text-gray-900">{{ $employer->verified_at->format('M d, Y') }}</span>
                </div>
                @endif
                
                <!-- Social Links -->
                @if($employer->linkedin_url || $employer->twitter_url)
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Social Links</p>
                    <div class="flex items-center gap-3">
                        @if($employer->linkedin_url)
                        <a href="{{ $employer->linkedin_url }}" target="_blank" 
                           class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                        @endif
                        @if($employer->twitter_url)
                        <a href="{{ $employer->twitter_url }}" target="_blank" 
                           class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            Twitter
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- ===== QUICK ACTIONS ===== -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.employers.edit', $employer->id) }}" 
           class="flex items-center justify-center gap-2 px-4 py-3.5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-[#1a237e]/20 text-sm font-medium text-gray-700 hover:text-[#1a237e] group">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#1a237e] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Company
        </a>
        
        @if($employer->verification_status !== 'verified')
            <button onclick="verifyCompany({{ $employer->id }})" 
                    class="flex items-center justify-center gap-2 px-4 py-3.5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-emerald-500/20 text-sm font-medium text-gray-700 hover:text-emerald-600 group">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verify Company
            </button>
            <form id="verify-form-{{ $employer->id }}" action="" method="POST" class="hidden">
                @csrf
            </form>
        @endif
        
        <a href="#" class="flex items-center justify-center gap-2 px-4 py-3.5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-blue-500/20 text-sm font-medium text-gray-700 hover:text-blue-600 group">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            View Activity
        </a>
        
        <a href="#" class="flex items-center justify-center gap-2 px-4 py-3.5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-red-500/20 text-sm font-medium text-gray-700 hover:text-red-600 group">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Reset Password
        </a>
    </div>
</div>

<script>
    function verifyCompany(id) {
        if (confirm('Verify this company?')) {
            document.getElementById('verify-form-' + id).submit();
        }
    }
</script>

@endsection