<!-- ============================================================ -->
<!-- JOB LISTINGS PAGE · Balanced Malaysian Theme                 -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    Find Your <span class="text-[#ff7543]">Dream Job</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Discover thousands of opportunities across Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">
                    Showing <span class="font-semibold text-[#1A237E]">{{ $jobs->total() }}</span> jobs
                </span>
                <button type="button" class="p-2.5 rounded-xl border border-gray-200 hover:border-[#ff7543] hover:bg-red-50 transition-all duration-300 text-gray-500 hover:text-[#ff7543]">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- ===== FILTERS FORM ===== -->
        <form method="GET" action="{{ route('user.job.listings') }}" id="filterForm"
              class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                <!-- Search Input -->
                <div class="relative lg:col-span-12">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search jobs, companies, or keywords..."
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                </div>


            </div>

            <!-- Hidden inputs to preserve sort when clicking chips -->
            <input type="hidden" name="sort" value="{{ request('sort', 'recent') }}">

            <!-- Filter Chips -->
            <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                <span class="text-xs font-medium text-gray-500 mr-1">Quick filters:</span>

                @php
                    $currentEmp = request('employment_type');
                    $currentWork = request('work_type');
                @endphp

                <a href="{{ route('user.job.listings', array_filter(request()->except(['employment_type', 'work_type', 'page']))) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ !$currentEmp && !$currentWork
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    All Jobs
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['work_type', 'page']), ['employment_type' => 'remote'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentEmp === 'remote'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Remote
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['work_type', 'page']), ['employment_type' => 'full_time'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentEmp === 'full_time'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Full-time
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['work_type', 'page']), ['employment_type' => 'part_time'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentEmp === 'part_time'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Part-time
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['work_type', 'page']), ['employment_type' => 'contract'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentEmp === 'contract'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Contract
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['work_type', 'page']), ['employment_type' => 'internship'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentEmp === 'internship'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Internship
                </a>

                <a href="{{ route('user.job.listings', array_merge(request()->except(['employment_type', 'page']), ['work_type' => 'hybrid'])) }}"
                   class="text-xs px-3 py-1.5 rounded-full transition-all border
                          {{ $currentWork === 'hybrid'
                                ? 'bg-[#1A237E] text-white border-[#1A237E]'
                                : 'bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] border-transparent hover:border-[#1A237E]/20' }}">
                    Hybrid
                </a>

                <button type="submit"
                        class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20 flex items-center gap-1">
                    <i class="fas fa-sliders-h text-[10px]"></i>
                    Apply Filters
                </button>
            </div>
        </form>

        <!-- ===== SORT & VIEW OPTIONS ===== -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500">Sort by:</span>
                <select name="sort" form="filterForm" onchange="document.getElementById('filterForm').submit()"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-white focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none cursor-pointer">
                    <option value="recent"   @selected(request('sort', 'recent') === 'recent')>Most Recent</option>
                    <option value="salary"   @selected(request('sort') === 'salary')>Highest Salary</option>
                    <option value="relevant" @selected(request('sort') === 'relevant')>Most Relevant</option>
                    <option value="applied"  @selected(request('sort') === 'applied')>Most Applied</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="p-2 rounded-lg bg-[#1A237E] text-white transition-all hover:bg-[#0D1445]">
                    <i class="fas fa-list"></i>
                </button>
                <button type="button" class="p-2 rounded-lg border border-gray-200 hover:border-[#1A237E] text-gray-500 hover:text-[#1A237E] transition-all">
                    <i class="fas fa-th"></i>
                </button>
            </div>
        </div>

        <!-- ===== JOB LISTINGS ===== -->
        <div class="space-y-4">
            @forelse($jobs as $job)
                @php
                    $isFeatured = $job->is_featured ?? false;
                @endphp

                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5 relative overflow-hidden
                            {{ $isFeatured ? 'border-l-4 border-l-[#ff7543]' : 'hover:border-[#1A237E]/20' }}">

                    @if($isFeatured)
                        <div class="absolute top-0 right-0 bg-[#ff7543] text-white text-[9px] font-bold px-3 py-1 rounded-bl-lg">
                            Featured
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">

                        <!-- Company Logo + Job Title -->
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center shrink-0 overflow-hidden">
                                @if($job->employer && $job->employer->company_logo)
                                    <img src="{{ asset('storage/' . $job->employer->company_logo) }}"
                                         alt="{{ $job->employer->company_name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="text-[#1A237E]">
                                        <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                        <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="text-base md:text-lg font-bold text-gray-900 transition-colors truncate
                                           {{ $isFeatured ? 'group-hover:text-[#ff7543]' : 'group-hover:text-[#1A237E]' }}">
                                    <a href="{{ route('user.job.details', $job->slug ?? $job->id) }}">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                    <span class="text-sm text-gray-600">
                                        {{ $job->employer?->company_name ?? 'Company' }}
                                    </span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                        {{ $job->location ?? 'Malaysia' }}
                                    </span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-xs text-gray-400">
                                        Posted {{ $job->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap items-center gap-2 md:gap-3">
                            @if($job->employment_type)
                                <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                                </span>
                            @endif

                            @if($job->work_type)
                                <span class="text-xs font-medium px-3 py-1 rounded-full
                                    @if($job->work_type === 'remote') bg-blue-50 text-blue-700
                                    @elseif($job->work_type === 'hybrid') bg-orange-50 text-orange-700
                                    @else bg-gray-50 text-gray-700
                                    @endif">
                                    {{ ucfirst($job->work_type) }}
                                </span>
                            @endif

                            @if($job->salary_min && $job->salary_max)
                                <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">
                                    {{ $job->currency ?? 'RM' }}
                                    {{ number_format($job->salary_min / 1000, 1) }}k–{{ number_format($job->salary_max / 1000, 1) }}k
                                </span>
                            @elseif($job->salary_min)
                                <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">
                                    {{ $job->currency ?? 'RM' }} {{ number_format($job->salary_min / 1000, 1) }}k+
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.job.details', $job->slug ?? $job->id) }}"
                               class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                                Apply Now
                            </a>
                            <button type="button"
                                    class="p-2 rounded-xl border border-gray-200 hover:border-[#ff7543] text-gray-400 hover:text-[#ff7543] transition-all"
                                    title="Save job">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">No jobs found</p>
                        <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or search terms.</p>

                        @if(request()->hasAny(['search', 'location', 'category', 'employment_type', 'work_type']))
                            <a href="{{ route('user.job.listings') }}"
                               class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-[#1A237E] hover:bg-[#0D1445] text-white text-sm font-semibold rounded-xl transition-all">
                                <i class="fas fa-redo text-xs"></i>
                                Clear all filters
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($jobs->hasPages())
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Showing
                    <span class="font-semibold text-[#1A237E]">{{ $jobs->firstItem() }}</span>–<span class="font-semibold text-[#1A237E]">{{ $jobs->lastItem() }}</span>
                    of <span class="font-semibold text-[#1A237E]">{{ $jobs->total() }}</span> jobs
                </p>
                <div>
                    {{ $jobs->links() }}
                </div>
            </div>
        @endif

    </div>
</main>

@endsection
