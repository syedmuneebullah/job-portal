{{-- resources/views/employer/pages/profile.blade.php --}}
@extends('employer.layouts.app')

@section('title', 'Company Profile')
@section('page-title', 'Company Profile')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- ===== HERO CARD ===== -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-4">
        <!-- Cover strip -->
        <div class="h-12 relative">
        </div>

        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-16 sm:-mt-12">
                <!-- Logo -->
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white border-4 border-white shadow-md overflow-hidden shrink-0 flex items-center justify-center">
                    @if($employer->logo_url)
                        <img src="{{ $employer->logo_url }}" alt="{{ $employer->company_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#1a237e] flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">{{ $employer->initials }}</span>
                        </div>
                    @endif
                </div>

                <!-- Name + meta -->
                <div class="flex-1 min-w-0 pb-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $employer->company_name }}</h1>
                        @if($employer->is_verified)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pending verification
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1.5 text-sm text-gray-500">
                        @if($employer->industry)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#ff7543]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $employer->industry }}
                            </span>
                        @endif
                        @if($employer->headquarters)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#ff7543]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $employer->headquarters }}
                            </span>
                        @endif
                        @if($employer->company_size)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#ff7543]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ $employer->company_size }} employees
                            </span>
                        @endif
                        @if($employer->founded_year)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#ff7543]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Est. {{ $employer->founded_year }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Edit button -->
                <div class="shrink-0">
                    <a href="{{ route('employer.profile.edit') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit profile
                    </a>
                </div>
            </div>

            <!-- Contact strip -->
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-5 pt-5 border-t border-gray-100 text-sm">
                @if($employer->email)
                    <a href="mailto:{{ $employer->email }}" class="flex items-center gap-1.5 text-gray-600 hover:text-[#1a237e] transition-colors">
                        <svg class="w-4 h-4 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $employer->email }}
                    </a>
                @endif
                @if($employer->phone)
                    <a href="tel:{{ $employer->phone }}" class="flex items-center gap-1.5 text-gray-600 hover:text-[#1a237e] transition-colors">
                        <svg class="w-4 h-4 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $employer->phone }}
                    </a>
                @endif
                @if($employer->website)
                    <a href="{{ $employer->website }}" target="_blank" rel="noopener" class="flex items-center gap-1.5 text-gray-600 hover:text-[#1a237e] transition-colors">
                        <svg class="w-4 h-4 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        {{ preg_replace('#^https?://#', '', rtrim($employer->website, '/')) }}
                    </a>
                @endif
                @if($employer->linkedin_url)
                    <a href="{{ $employer->linkedin_url }}" target="_blank" rel="noopener" class="flex items-center gap-1.5 text-gray-600 hover:text-[#1a237e] transition-colors">
                        <svg class="w-4 h-4 text-[#1a237e]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        LinkedIn
                    </a>
                @endif
                @if($employer->twitter_url)
                    <a href="{{ $employer->twitter_url }}" target="_blank" rel="noopener" class="flex items-center gap-1.5 text-gray-600 hover:text-[#1a237e] transition-colors">
                        <svg class="w-4 h-4 text-[#1a237e]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        Twitter / X
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
        <div class="bg-white rounded-lg border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#1a237e]/10 flex items-center justify-center text-[#1a237e] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_jobs'] }}</p>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total jobs</p>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_jobs'] }}</p>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Active jobs</p>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#ff7543]/10 flex items-center justify-center text-[#ff7543] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_applications'] }}</p>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Applications</p>
            </div>
        </div>
    </div>

    <!-- ===== ABOUT COMPANY ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Left: description -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-3">About the company</h2>
                @if($employer->company_description)
                    <div class="prose prose-sm max-w-none text-gray-600 whitespace-pre-line">{!! $employer->company_description !!}</div>
                @else
                    <p class="text-sm text-gray-400 italic">No description added yet. Click "Edit profile" to tell candidates about your company.</p>
                @endif
            </div>

            <!-- Recent jobs -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-gray-900">Recent jobs</h2>
                    <a href="{{ route('employer.jobs.index') }}" class="text-sm font-semibold text-[#1a237e] hover:underline">View all</a>
                </div>

                @if($recentJobs->count())
                    <div class="divide-y divide-gray-100">
                        @foreach($recentJobs as $job)
                            <div class="flex items-center justify-between py-3 first:pt-0 last:pb-0">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $job->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->location }} · {{ ucfirst($job->employment_type ?? 'N/A') }}</p>
                                </div>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                    @if($job->status === 'published') bg-emerald-50 text-emerald-700
                                    @elseif($job->status === 'draft') bg-gray-100 text-gray-600
                                    @else bg-amber-50 text-amber-700
                                    @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 italic">No jobs posted yet.</p>
                @endif
            </div>
        </div>

        <!-- Right: company facts -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Company details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Industry</dt>
                        <dd class="font-medium text-gray-800 text-right">{{ $employer->industry ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Company size</dt>
                        <dd class="font-medium text-gray-800 text-right">{{ $employer->company_size ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Founded</dt>
                        <dd class="font-medium text-gray-800 text-right">{{ $employer->founded_year ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Headquarters</dt>
                        <dd class="font-medium text-gray-800 text-right">{{ $employer->headquarters ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Verified</dt>
                        <dd class="text-right">
                            @if($employer->is_verified)
                                <span class="text-emerald-600 font-medium">Yes</span>
                            @else
                                <span class="text-amber-600 font-medium">Pending</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

</div>
@endsection