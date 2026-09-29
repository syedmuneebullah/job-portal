{{-- resources/views/employer/pages/dashboard.blade.php --}}
@extends('employer.layouts.app')

@section('title', 'Dashboard - Employer Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ===== WELCOME BAR ===== --}}
    <div class="bg-gradient-to-r from-[#1a237e] to-[#0d1445] rounded-xl p-6 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 50%, #ff7543 0%, transparent 40%), radial-gradient(circle at 80% 50%, #ff7543 0%, transparent 40%);"></div>
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold">Welcome back, {{ $employer->company_name }} 👋</h2>
                <p class="text-sm text-white/80 mt-1">Here's what's happening with your hiring today.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('employer.jobs.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#ff7543] hover:bg-[#e5643a] text-white text-sm font-semibold rounded-lg transition-all shadow-lg shadow-[#ff7543]/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Post a Job
                </a>
                <a href="{{ route('employer.jobs.screen-all') ?? '#' }}"
                   onclick="event.preventDefault(); document.getElementById('screenAllForm').submit();"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-semibold rounded-lg transition-all border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Screen All
                </a>
                <form id="screenAllForm" action="{{ route('employer.jobs.screen-all') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    {{-- ===== PRIMARY STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Jobs -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_jobs']) }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-0.5 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            {{ $stats['active_jobs'] }} active
                        </span>
                        <span class="text-xs text-gray-400">·</span>
                        <span class="text-xs text-gray-400">{{ $stats['draft_jobs'] }} drafts</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-[#1a237e]/10 flex items-center justify-center text-[#1a237e] group-hover:bg-[#1a237e] group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="w-10 h-10 rounded-lg bg-[#ff7543]/10 flex items-center justify-center text-[#ff7543] group-hover:bg-[#ff7543] group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Strong Matches -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Strong Matches</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ number_format($stats['total_strong_matches']) }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs text-gray-400">Top-tier candidates ready to review</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Hired -->
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-200">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Hired</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['hired_count']) }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs text-gray-400">{{ $stats['interview_count'] }} in interview</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SECONDARY STATS ROW ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Pending Review</p>
            <p class="text-xl font-bold text-amber-600">{{ number_format($stats['pending_count']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Under Review</p>
            <p class="text-xl font-bold text-blue-600">{{ number_format($stats['under_review_count']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Shortlisted</p>
            <p class="text-xl font-bold text-indigo-600">{{ number_format($stats['shortlisted_count']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Knocked Out</p>
            <p class="text-xl font-bold text-rose-600">{{ number_format($stats['total_knocked_out']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Not Screened</p>
            <p class="text-xl font-bold text-gray-700">{{ number_format($stats['unscreened_jobs']) }}</p>
            <p class="text-[10px] text-gray-400">jobs with unscreened apps</p>
        </div>
    </div>

    {{-- ===== CHARTS ROW 1 ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Activity line -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Hiring Activity — Last 30 Days</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Applications received per day</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ff7543]"></span>
                        <span class="text-gray-500">Applications</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#1a237e]"></span>
                        <span class="text-gray-500">Jobs posted</span>
                    </span>
                </div>
            </div>
            <div class="h-[280px]">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Application status doughnut -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Pipeline Status</h3>
            <p class="text-xs text-gray-400 mb-5">All applications</p>
            <div class="h-[260px] flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ROW 2 ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Top performing jobs -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Top Performing Jobs</h3>
            <p class="text-xs text-gray-400 mb-5">By application count</p>
            <div class="h-[260px]">
                <canvas id="topJobsChart"></canvas>
            </div>
        </div>

        <!-- Screening distribution -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">Screening Distribution</h3>
            <p class="text-xs text-gray-400 mb-5">Candidate quality breakdown</p>
            <div class="h-[260px] flex items-center justify-center">
                <canvas id="screeningChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== TOP CANDIDATES TO REVIEW ===== --}}
    @if($topCandidates->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Top Candidates to Review
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">Highest-scoring applicants across all jobs</p>
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($topCandidates as $app)
                @php
                    $badge = match($app->screening_band) {
                        'strong'  => ['bg-emerald-500', 'text-white'],
                        'good'    => ['bg-blue-500',    'text-white'],
                        'average' => ['bg-amber-500',   'text-white'],
                        default   => ['bg-gray-400',    'text-white'],
                    };
                @endphp
                <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                    <div class="w-12 h-12 rounded-full {{ $badge[0] }} {{ $badge[1] }} flex items-center justify-center font-bold shrink-0">
                        {{ (int) $app->screening_score }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ trim(($app->applicant?->first_name ?? '') . ' ' . ($app->applicant?->last_name ?? '')) ?: 'Unknown' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            Applied for <span class="font-medium text-gray-700">{{ $app->jobPost?->title ?? 'a job' }}</span>
                            · {{ ucfirst($app->screening_band ?? 'n/a') }} match
                        </p>
                    </div>
                    <a href="{{ route('employer.applications.show', $app->id) }}"
                       class="px-3 py-1.5 bg-[#1a237e] hover:bg-[#0d1445] text-white text-xs font-semibold rounded-lg transition-colors shrink-0">
                        Review
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ===== RECENT ACTIVITY ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Applications -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Applications</h3>
                <a href="{{ route('employer.applications.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                    View all →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentApplications as $app)
                    <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#1a237e] to-[#0d1445] flex items-center justify-center text-xs font-semibold text-white shrink-0">
                            {{ strtoupper(substr($app->applicant?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($app->applicant?->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ trim(($app->applicant?->first_name ?? '') . ' ' . ($app->applicant?->last_name ?? '')) ?: 'Unknown' }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ $app->jobPost?->title ?? 'Job deleted' }} · {{ $app->created_at->diffForHumans() }}
                            </p>
                        </div>
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
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No applications yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Jobs</h3>
                <a href="{{ route('employer.jobs.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
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
                                {{ $job->applications_count }} application{{ $job->applications_count === 1 ? '' : 's' }}
                                · {{ $job->created_at->diffForHumans() }}
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

    {{-- ===== UPCOMING INTERVIEWS ===== --}}
    @if($upcomingInterviews->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-sm font-semibold text-gray-900">Upcoming Interviews</h3>
            <a href="{{ route('employer.interviews.index') }}" class="text-xs font-medium text-gray-400 hover:text-gray-600 transition-colors">
                View all →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($upcomingInterviews as $interview)
                <div class="p-4 rounded-lg border border-gray-100 hover:border-[#1a237e]/20 hover:shadow-md transition-all">
                    <div class="flex items-center gap-2 text-xs text-[#ff7543] font-semibold uppercase tracking-wide mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('M d, H:i') }}
                    </div>
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ trim(($interview->application?->applicant?->first_name ?? '') . ' ' . ($interview->application?->applicant?->last_name ?? '')) ?: 'Unknown' }}
                    </p>
                    <p class="text-xs text-gray-400 truncate mt-0.5">
                        {{ $interview->application?->jobPost?->title ?? 'Job' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- ===== CHART.JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#6b7280';

    // ---------- 1. ACTIVITY LINE ----------
    const ctx1 = document.getElementById('activityChart');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: @json($lineChart['labels']),
                datasets: [
                    {
                        label: 'Applications',
                        data: @json($lineChart['applications']),
                        borderColor: '#ff7543',
                        backgroundColor: 'rgba(255, 117, 67, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Jobs',
                        data: @json($lineChart['jobs']),
                        borderColor: '#1a237e',
                        backgroundColor: 'rgba(26, 35, 126, 0.06)',
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
                    x: { grid: { display: false }, ticks: { maxRotation: 0, autoSkipPadding: 20 } },
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { precision: 0 } }
                }
            }
        });
    }

    // ---------- 2. STATUS DOUGHNUT ----------
    const ctx2 = document.getElementById('statusChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: @json($doughnutChart['labels']),
                datasets: [{
                    data: @json($doughnutChart['data']),
                    backgroundColor: ['#6b7280','#3b82f6','#6366f1','#a855f7','#f59e0b','#10b981','#ef4444','#9ca3af'],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 8, boxHeight: 8, padding: 10, usePointStyle: true, pointStyle: 'circle' } }
                }
            }
        });
    }

    // ---------- 3. TOP JOBS BAR ----------
    const ctx3 = document.getElementById('topJobsChart');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: @json($barChart['labels']),
                datasets: [{
                    label: 'Applications',
                    data: @json($barChart['data']),
                    backgroundColor: '#1a237e',
                    borderRadius: 6,
                    barThickness: 26,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { precision: 0 } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    // ---------- 4. SCREENING DOUGHNUT ----------
    const ctx4 = document.getElementById('screeningChart');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: @json($screeningChart['labels']),
                datasets: [{
                    data: @json($screeningChart['data']),
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 8, boxHeight: 8, padding: 10, usePointStyle: true, pointStyle: 'circle' } }
                }
            }
        });
    }
})();
</script>
@endsection