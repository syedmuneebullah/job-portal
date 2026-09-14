<!-- ============================================================ -->
<!-- COMPANY PROFILE PAGE · Balanced Malaysian Theme              -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">

    <!-- ===== HERO / BANNER ===== -->
    <div class="relative h-48 md:h-64 bg-gradient-to-r from-[#1A237E] via-[#283593] to-[#ff7543]">
        <div class="absolute inset-0 bg-black/10"></div>
        <!-- Optional: replace with company cover image -->
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 md:-mt-24 relative z-10 pb-10">

        <!-- ===== COMPANY HEADER CARD ===== -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100/80 p-5 md:p-8 mb-6">

            <div class="flex flex-col md:flex-row md:items-start gap-5 md:gap-8">
                <!-- Logo -->
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-gray-100 border-4 border-white shadow-md flex items-center justify-center text-[#1A237E] text-4xl font-bold shrink-0 overflow-hidden -mt-12 md:-mt-16">
                    @if($company->company_logo)
                        <img src="{{ asset('storage/' . $company->company_logo) }}" alt="{{ $company->company_name }}" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                            <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                        </svg>
                    @endif
                </div>

                <!-- Company Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $company->company_name }}</h1>
                        @if($company->verification_status == 'verified')
                            <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full flex items-center gap-1">
                                <i class="fas fa-check-circle text-[10px]"></i> Verified
                            </span>
                        @endif
                    </div>

                    <!-- Meta row -->
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600">
                        @if($company->industry)
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-briefcase text-[#ff7543]"></i>
                            {{ $company->industry }}
                        </span>
                        @endif
                        @if($company->headquarters)
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-map-marker-alt text-[#ff7543]"></i>
                            {{ $company->headquarters }}
                        </span>
                        @endif
                        @if($company->company_size)
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-users text-[#ff7543]"></i>
                            {{ $company->company_size }} employees
                        </span>
                        @endif
                        @if($company->founded_year)
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-calendar-alt text-[#ff7543]"></i>
                            Founded {{ $company->founded_year }}
                        </span>
                        @endif
                    </div>

                    <!-- Contact row -->
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 mt-3">
                        @if($company->email)
                        <a href="mailto:{{ $company->email }}" class="flex items-center gap-1.5 hover:text-[#ff7543] transition-colors">
                            <i class="fas fa-envelope text-[#ff7543]"></i>
                            {{ $company->email }}
                        </a>
                        @endif
                        @if($company->phone)
                        <a href="tel:{{ $company->phone }}" class="flex items-center gap-1.5 hover:text-[#ff7543] transition-colors">
                            <i class="fas fa-phone text-[#ff7543]"></i>
                            {{ $company->phone }}
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row md:flex-col gap-2 shrink-0">
                    @if($company->website)
                    <a href="{{ $company->website }}" target="_blank"
                       class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg text-center whitespace-nowrap flex items-center justify-center gap-2">
                        <i class="fas fa-external-link-alt text-xs"></i> Visit Website
                    </a>
                    @endif
                    <button class="px-4 py-2 border border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="far fa-bookmark"></i> Follow
                    </button>
                </div>
            </div>

            <!-- Social Links -->
            @if($company->linkedin_url || $company->twitter_url)
            <div class="flex flex-wrap items-center gap-3 mt-5 pt-5 border-t border-gray-100">
                <span class="text-xs font-medium text-gray-500">Connect:</span>
                @if($company->linkedin_url)
                <a href="{{ $company->linkedin_url }}" target="_blank"
                   class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-[#0A66C2] text-gray-600 hover:text-white flex items-center justify-center transition-all border border-gray-200 hover:border-[#0A66C2]">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                @endif
                @if($company->twitter_url)
                <a href="{{ $company->twitter_url }}" target="_blank"
                   class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-[#1DA1F2] text-gray-600 hover:text-white flex items-center justify-center transition-all border border-gray-200 hover:border-[#1DA1F2]">
                    <i class="fab fa-twitter"></i>
                </a>
                @endif
            </div>
            @endif
        </div>

        <!-- ===== STATS CARDS ===== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 text-center">
                <div class="text-2xl font-bold text-[#1A237E]">{{ $totalJobs }}</div>
                <div class="text-xs text-gray-500 mt-1">Total Jobs</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 text-center">
                <div class="text-2xl font-bold text-[#ff7543]">{{ $openJobs }}</div>
                <div class="text-xs text-gray-500 mt-1">Open Positions</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-600">{{ $company->company_size ?? '—' }}</div>
                <div class="text-xs text-gray-500 mt-1">Team Size</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $company->founded_year ?? '—' }}</div>
                <div class="text-xs text-gray-500 mt-1">Founded</div>
            </div>
        </div>

        <!-- ===== MAIN GRID: ABOUT + JOBS ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT COLUMN: About -->
            <div class="lg:col-span-1 space-y-6">
                <!-- About Company -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6">
                    <h2 class="text-lg font-bold text-[#1A237E] mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-[#ff7543]"></i> About Company
                    </h2>
                    @if($company->company_description)
                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                            {{ $company->company_description }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400 italic">No description provided.</p>
                    @endif
                </div>

                <!-- Company Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6">
                    <h2 class="text-lg font-bold text-[#1A237E] mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-[#ff7543]"></i> Company Details
                    </h2>
                    <ul class="space-y-3 text-sm">
                        @if($company->industry)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Industry</span>
                            <span class="font-medium text-gray-800 text-right">{{ $company->industry }}</span>
                        </li>
                        @endif
                        @if($company->company_size)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Company Size</span>
                            <span class="font-medium text-gray-800 text-right">{{ $company->company_size }}</span>
                        </li>
                        @endif
                        @if($company->founded_year)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Founded</span>
                            <span class="font-medium text-gray-800 text-right">{{ $company->founded_year }}</span>
                        </li>
                        @endif
                        @if($company->headquarters)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Headquarters</span>
                            <span class="font-medium text-gray-800 text-right">{{ $company->headquarters }}</span>
                        </li>
                        @endif
                        @if($company->website)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Website</span>
                            <a href="{{ $company->website }}" target="_blank" class="font-medium text-[#ff7543] hover:underline text-right truncate max-w-[60%]">
                                {{ parse_url($company->website, PHP_URL_HOST) ?? $company->website }}
                            </a>
                        </li>
                        @endif
                        @if($company->email)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Email</span>
                            <a href="mailto:{{ $company->email }}" class="font-medium text-[#ff7543] hover:underline text-right truncate max-w-[60%]">
                                {{ $company->email }}
                            </a>
                        </li>
                        @endif
                        @if($company->phone)
                        <li class="flex justify-between gap-3">
                            <span class="text-gray-500">Phone</span>
                            <a href="tel:{{ $company->phone }}" class="font-medium text-[#ff7543] hover:underline text-right">
                                {{ $company->phone }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- RIGHT COLUMN: Jobs -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-lg font-bold text-[#1A237E] flex items-center gap-2">
                            <i class="fas fa-briefcase text-[#ff7543]"></i>
                            Open Positions
                            <span class="text-xs font-medium bg-[#1A237E]/10 text-[#1A237E] px-2 py-0.5 rounded-full ml-1">{{ $totalJobs }}</span>
                        </h2>
                    </div>

                    <div class="space-y-4">
                        @forelse($jobs as $job)
                        <!-- Job Card -->
                        <div class="group border border-gray-100/80 hover:border-[#1A237E]/30 rounded-xl p-4 hover:shadow-md transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">

                                <!-- Job Icon -->
                                <div class="w-11 h-11 rounded-lg bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                                    <i class="fas fa-briefcase"></i>
                                </div>

                                <!-- Job Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors truncate">
                                        {{ $job->title ?? $job->job_title ?? 'Untitled Position' }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                                        @if($job->location)
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-[#ff7543] text-[10px]"></i>
                                            {{ $job->location }}
                                        </span>
                                        @endif
                                        @if($job->employment_type)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ $job->employment_type }}</span>
                                        @endif
                                        @if($job->created_at)
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ $job->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($job->work_type)
                                    <span class="text-[10px] font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">
                                        {{ $job->work_type }}
                                    </span>
                                    @endif
                                    @if($job->salary_range)
                                    <span class="text-[10px] font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">
                                        {{ $job->salary_range }}
                                    </span>
                                    @endif
                                </div>

                                <!-- Action -->
                                <a href="{{ route('user.job.details', $job->id) }}"
                                   class="px-3.5 py-1.5 bg-[#1A237E] hover:bg-[#0D1445] text-white text-xs font-semibold rounded-lg transition-all whitespace-nowrap text-center">
                                    View
                                </a>
                            </div>
                        </div>
                        @empty
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-briefcase text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-base font-semibold text-gray-700 mb-1">No open positions</h3>
                            <p class="text-sm text-gray-500">This company hasn't posted any jobs yet.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($jobs->hasPages())
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        {{ $jobs->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
