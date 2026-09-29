{{-- resources/views/admin/pages/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ===== STATS CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Users -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    <div class="flex items-center gap-1.5">
                        @php $g = $stats['users_growth']; @endphp
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $g >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($g >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                @endif
                            </svg>
                            {{ abs($g) }}%
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
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_jobs']) }}</p>
                    <div class="flex items-center gap-1.5">
                        @php $g = $stats['jobs_growth']; @endphp
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $g >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($g >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                @endif
                            </svg>
                            {{ abs($g) }}%
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
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_applications']) }}</p>
                    <div class="flex items-center gap-1.5">
                        @php $g = $stats['apps_growth']; @endphp
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $g >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($g >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                @endif
                            </svg>
                            {{ abs($g) }}%
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
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            {{ $activeSubscriptions }} active plans
                        </span>
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

    {{-- ===== SECONDARY STATS (small badges) ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Active Jobs</p>
            <p class="text-xl font-bold text-emerald-600">{{ number_format($stats['active_jobs']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Draft Jobs</p>
            <p class="text-xl font-bold text-amber-600">{{ number_format($stats['draft_jobs']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Shortlisted</p>
            <p class="text-xl font-bold text-blue-600">{{ number_format($stats['shortlisted_count']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Hired</p>
            <p class="text-xl font-bold text-emerald-600">{{ number_format($stats['hired_count']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Rejected</p>
            <p class="text-xl font-bold text-rose-600">{{ number_format($stats['rejected_count']) }}</p>
        </div>
    </div>

    {{-- ===== CHARTS ROW 1: Line + Doughnut ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Line chart — activity last 30 days -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Activity — Last 30 Days</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Daily users, jobs, and applications</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#1a237e]"></span>
                        <span class="text-gray-500">Users</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ff7543]"></span>
                        <span class="text-gray-500">Applications</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="text-gray-500">Jobs</span>
                    </span>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Doughnut chart — Applications by status -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Applications by Status</h3>
            <p class="text-xs text-gray-400 mb-5">All time distribution</p>
            <div class="h-[260px] flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ROW 2: Bar + Employment Pie + Revenue line ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Bar — Top employers -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Top Employers</h3>
            <p class="text-xs text-gray-400 mb-5">By number of jobs posted</p>
            <div class="h-[260px]">
                <canvas id="employersChart"></canvas>
            </div>
        </div>

        <!-- Pie — Employment type -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Jobs by Employment Type</h3>
            <p class="text-xs text-gray-400 mb-5">Distribution across all jobs</p>
            <div class="h-[260px] flex items-center justify-center">
                <canvas id="employmentChart"></canvas>
            </div>
        </div>

        <!-- Line — Revenue last 6 months -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Revenue</h3>
            <p class="text-xs text-gray-400 mb-5">Last 6 months</p>
            <div class="h-[260px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== RECENT ACTIVITY ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#1a237e] to-[#0d1445] flex items-center justify-center text-xs font-semibold text-white shrink-0">
                            {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Unknown' }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if(($user->status ?? 'active') === 'active') bg-emerald-50 text-emerald-700
                            @elseif(($user->status ?? '') === 'pending') bg-amber-50 text-amber-700
                            @else bg-gray-50 text-gray-700
                            @endif">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No users yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Jobs</h3>
                <a href="{{ route('admin.jobs.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentJobs as $job)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $job->title }}</p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ $job->employer?->company_name ?? 'Unknown' }}
                                · {{ ucfirst(str_replace('_', ' ', $job->employment_type ?? 'N/A')) }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($job->status === 'published') bg-emerald-50 text-emerald-700
                            @elseif($job->status === 'draft') bg-amber-50 text-amber-700
                            @else bg-gray-50 text-gray-700
                            @endif">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No jobs yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== RECENT APPLICATIONS ===== --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-sm font-semibold text-gray-900">Recent Applications</h3>
            <a href="#" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">View all →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider py-2">Applicant</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider py-2">Job</th>
                        <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider py-2">Status</th>
                        <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider py-2">Applied</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentApplications as $app)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 shrink-0">
                                        {{ strtoupper(substr($app->applicant?->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ trim(($app->applicant?->first_name ?? '') . ' ' . ($app->applicant?->last_name ?? '')) ?: 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-gray-400 truncate">{{ $app->applicant?->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-700 truncate max-w-xs">
                                {{ $app->jobPost?->title ?? 'Job deleted' }}
                            </td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($app->status === 'applied') bg-gray-50 text-gray-700
                                    @elseif($app->status === 'under_review') bg-blue-50 text-blue-700
                                    @elseif($app->status === 'shortlisted') bg-indigo-50 text-indigo-700
                                    @elseif($app->status === 'interview') bg-purple-50 text-purple-700
                                    @elseif($app->status === 'offer') bg-amber-50 text-amber-700
                                    @elseif($app->status === 'hired') bg-emerald-50 text-emerald-700
                                    @elseif($app->status === 'rejected') bg-rose-50 text-rose-700
                                    @else bg-gray-50 text-gray-700
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $app->status)) }}
                                </span>
                            </td>
                            <td class="py-3 text-right text-xs text-gray-500">
                                {{ $app->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-sm text-gray-400">No applications yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    // Chart.js global defaults
    Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size   = 11;
    Chart.defaults.color       = '#6b7280';

    // ---------- 1. ACTIVITY LINE CHART ----------
    const activityCtx = document.getElementById('activityChart');
    if (activityCtx) {
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: @json($lineChart['labels']),
                datasets: [
                    {
                        label: 'Users',
                        data: @json($lineChart['users']),
                        borderColor: '#1a237e',
                        backgroundColor: 'rgba(26, 35, 126, 0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Applications',
                        data: @json($lineChart['applications']),
                        borderColor: '#ff7543',
                        backgroundColor: 'rgba(255, 117, 67, 0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Jobs',
                        data: @json($lineChart['jobs']),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#f9fafb',
                        bodyColor: '#e5e7eb',
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxRotation: 0, autoSkipPadding: 20 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }

    // ---------- 2. STATUS DOUGHNUT ----------
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($doughnutChart['labels']),
                datasets: [{
                    data: @json($doughnutChart['data']),
                    backgroundColor: [
                        '#6b7280', // applied
                        '#3b82f6', // under_review
                        '#6366f1', // shortlisted
                        '#a855f7', // interview
                        '#f59e0b', // offer
                        '#10b981', // hired
                        '#ef4444', // rejected
                        '#9ca3af', // withdrawn
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                }
            }
        });
    }

    // ---------- 3. TOP EMPLOYERS BAR ----------
    const empCtx = document.getElementById('employersChart');
    if (empCtx) {
        new Chart(empCtx, {
            type: 'bar',
            data: {
                labels: @json($barChart['labels']),
                datasets: [{
                    label: 'Jobs posted',
                    data: @json($barChart['data']),
                    backgroundColor: '#1a237e',
                    borderRadius: 6,
                    barThickness: 24,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // horizontal bars
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { precision: 0 }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ---------- 4. EMPLOYMENT TYPE PIE ----------
    const typeCtx = document.getElementById('employmentChart');
    if (typeCtx) {
        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: @json($employmentChart['labels']),
                datasets: [{
                    data: @json($employmentChart['data']),
                    backgroundColor: [
                        '#1a237e',
                        '#ff7543',
                        '#10b981',
                        '#f59e0b',
                        '#3b82f6',
                        '#a855f7',
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                }
            }
        });
    }

    // ---------- 5. REVENUE LINE ----------
    const revCtx = document.getElementById('revenueChart');
    if (revCtx) {
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: @json($revenueChart['labels']),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenueChart['data']),
                    borderColor: '#ff7543',
                    backgroundColor: 'rgba(255, 117, 67, 0.12)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#ff7543',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => '$' + Number(ctx.parsed.y).toLocaleString()
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            callback: (v) => '$' + v,
                        }
                    }
                }
            }
        });
    }
})();
</script>
@endsection