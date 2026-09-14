<!-- ============================================================ -->
<!-- COMPANIES LISTING PAGE · Grid View · Malaysian Theme        -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Discover <span class="text-[#ff7543]">Top Companies</span></h1>
                <p class="text-sm text-gray-500 mt-1">Explore verified employers across Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Showing <span class="font-semibold text-[#1A237E]">{{ $companies->count() }}</span> companies</span>
                <button class="p-2.5 rounded-xl border border-gray-200 hover:border-[#ff7543] hover:bg-red-50 transition-all duration-300 text-gray-500 hover:text-[#ff7543]">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>

        <!-- ===== FILTERS BAR ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="relative lg:col-span-2">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search companies, industries, or keywords..."
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                </div>

                <!-- Industry -->
                <div class="relative">
                    <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Industries</option>
                        <option>Technology</option>
                        <option>Design</option>
                        <option>Finance</option>
                        <option>Marketing</option>
                        <option>Healthcare</option>
                        <option>Education</option>
                        <option>Engineering</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>

                <!-- Location -->
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Locations</option>
                        <option>Kuala Lumpur</option>
                        <option>Selangor</option>
                        <option>Penang</option>
                        <option>Johor</option>
                        <option>Sarawak</option>
                        <option>Sabah</option>
                        <option>Remote</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Filter Chips -->
            <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                <span class="text-xs font-medium text-gray-500 mr-1">Quick filters:</span>
                <button class="text-xs px-3 py-1.5 rounded-full bg-[#1A237E] text-white transition-all hover:bg-[#0D1445]">All Companies</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Verified</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Hiring Now</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Remote Friendly</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20 flex items-center gap-1">
                    <i class="fas fa-sliders-h text-[10px]"></i>
                    More filters
                </button>
            </div>
        </div>

        <!-- ===== SORT & VIEW OPTIONS ===== -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500">Sort by:</span>
                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 bg-white focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none">
                    <option>Most Recent</option>
                    <option>Company Size</option>
                    <option>Most Jobs</option>
                    <option>Alphabetical</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <!-- List View Button (inactive) -->
                <button class="p-2 rounded-lg border border-gray-200 hover:border-[#1A237E] text-gray-500 hover:text-[#1A237E] transition-all">
                    <i class="fas fa-list"></i>
                </button>
                <!-- Grid View Button (active) -->
                <button class="p-2 rounded-lg bg-[#1A237E] text-white transition-all hover:bg-[#0D1445]">
                    <i class="fas fa-th"></i>
                </button>
            </div>
        </div>

        <!-- ===== COMPANY GRID ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5">

            @forelse($companies as $company)
            <!-- Company Grid Card -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 hover:-translate-y-1 relative overflow-hidden flex flex-col">

                @if($company->verification_status == 'verified')
                <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[9px] font-bold px-2.5 py-1 rounded-bl-lg flex items-center gap-1">
                    <i class="fas fa-check-circle text-[8px]"></i> Verified
                </div>
                @endif

                <!-- Company Logo -->
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-3xl font-bold overflow-hidden border border-gray-100 group-hover:scale-105 transition-transform duration-300">
                        @if($company->company_logo)
                            <img src="{{ asset('storage/' . $company->company_logo) }}" alt="{{ $company->company_name }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Company Name -->
                <h3 class="text-base font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors text-center truncate">
                    {{ $company->company_name }}
                </h3>

                <!-- Industry -->
                @if($company->industry)
                <p class="text-xs text-[#ff7543] font-medium text-center mt-1">{{ $company->industry }}</p>
                @endif

                <!-- Location & Size -->
                <div class="flex items-center justify-center gap-2 text-xs text-gray-500 mt-2 flex-wrap">
                    @if($company->headquarters)
                    <span class="flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-[#ff7543] text-[10px]"></i>
                        {{ $company->headquarters }}
                    </span>
                    @endif
                    @if($company->headquarters && $company->company_size)
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    @endif
                    @if($company->company_size)
                    <span>{{ $company->company_size }} employees</span>
                    @endif
                </div>

                <!-- Description -->
                @if($company->company_description)
                <p class="text-xs text-gray-500 mt-3 line-clamp-2 text-center leading-relaxed">
                    {{ Str::limit($company->company_description, 90) }}
                </p>
                @endif

                <!-- Badges -->
                <div class="flex items-center justify-center gap-1.5 mt-3 flex-wrap">
                    @if($company->founded_year)
                    <span class="text-[10px] font-medium bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">
                        Est. {{ $company->founded_year }}
                    </span>
                    @endif
                    @if($company->website)
                    <a href="{{ $company->website }}" target="_blank" class="text-[10px] font-medium bg-gray-50 text-gray-600 hover:bg-gray-100 px-2 py-0.5 rounded-full flex items-center gap-1 transition-colors border border-gray-200">
                        <i class="fas fa-globe text-[8px]"></i> Website
                    </a>
                    @endif
                </div>

                <!-- Spacer to push actions to bottom -->
                <div class="flex-1"></div>

                <!-- Actions -->
                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('company.profile', $company->id) }}"
                    class="flex-1 px-3 py-2 bg-[#1A237E] hover:bg-[#0D1445] text-white text-xs font-semibold rounded-xl transition-all duration-300 text-center whitespace-nowrap">
                        View Profile
                    </a>
                    <button class="p-2 rounded-xl border border-gray-200 hover:border-[#ff7543] text-gray-400 hover:text-[#ff7543] transition-all">
                        <i class="far fa-bookmark text-sm"></i>
                    </button>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100/80 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-building text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">No companies found</h3>
                <p class="text-sm text-gray-500">Try adjusting your filters or search keywords.</p>
            </div>
            @endforelse
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($companies->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">Showing <span class="font-semibold text-[#1A237E]">{{ $companies->firstItem() }}-{{ $companies->lastItem() }}</span> of <span class="font-semibold text-[#1A237E]">{{ $companies->total() }}</span> companies</p>
            <div class="flex items-center gap-1.5">
                {{ $companies->links() }}
            </div>
        </div>
        @endif
    </div>
</main>

@endsection
