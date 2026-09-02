{{-- resources/views/admin/dashboard.blade.php --}}
@extends('employer.layouts.app')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Users -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">1,245</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            12.5%
                        </span>
                        <span class="text-xs text-gray-400">vs last month</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Jobs -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-900">348</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            8.2%
                        </span>
                        <span class="text-xs text-gray-400">vs last month</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Applications -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Applications</p>
                    <p class="text-2xl font-bold text-gray-900">2,847</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            24.8%
                        </span>
                        <span class="text-xs text-gray-400">vs last month</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">$12.4K</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            3.1%
                        </span>
                        <span class="text-xs text-gray-400">vs last month</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RECENT ACTIVITY ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Users</h3>
                <button class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </button>
            </div>

            <div class="space-y-3">
                <!-- User 1 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 group-hover:bg-gray-200 transition-colors">
                        JD
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">John Doe</p>
                        <p class="text-xs text-gray-400 truncate">john@example.com</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                        Active
                    </span>
                </div>

                <!-- User 2 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 group-hover:bg-gray-200 transition-colors">
                        JS
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Jane Smith</p>
                        <p class="text-xs text-gray-400 truncate">jane@example.com</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                        Pending
                    </span>
                </div>

                <!-- User 3 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 group-hover:bg-gray-200 transition-colors">
                        RB
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Robert Brown</p>
                        <p class="text-xs text-gray-400 truncate">robert@example.com</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                        Active
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Jobs</h3>
                <button class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </button>
            </div>

            <div class="space-y-3">
                <!-- Job 1 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Senior Developer</p>
                        <p class="text-xs text-gray-400 truncate">Tech Corp • Full Time</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                        Pending
                    </span>
                </div>

                <!-- Job 2 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Product Manager</p>
                        <p class="text-xs text-gray-400 truncate">Innovation Labs • Remote</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                        Active
                    </span>
                </div>

                <!-- Job 3 -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer group">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">UX Designer</p>
                        <p class="text-xs text-gray-400 truncate">Design Studio • Part Time</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                        Interview
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
