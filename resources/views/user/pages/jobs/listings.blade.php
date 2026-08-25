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
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Find Your <span class="text-[#ff7543]">Dream Job</span></h1>
                <p class="text-sm text-gray-500 mt-1">Discover thousands of opportunities across Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Showing <span class="font-semibold text-[#1A237E]">24</span> jobs</span>
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
                    <input type="text" placeholder="Search jobs, companies, or keywords..." 
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
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

                <!-- Category -->
                <div class="relative">
                    <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Categories</option>
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
            </div>

            <!-- Filter Chips -->
            <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                <span class="text-xs font-medium text-gray-500 mr-1">Quick filters:</span>
                <button class="text-xs px-3 py-1.5 rounded-full bg-[#1A237E] text-white transition-all hover:bg-[#0D1445]">All Jobs</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Remote</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Full-time</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Part-time</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Contract</button>
                <button class="text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#1A237E] transition-all border border-transparent hover:border-[#1A237E]/20">Internship</button>
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
                    <option>Highest Salary</option>
                    <option>Most Relevant</option>
                    <option>Most Applied</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-2 rounded-lg bg-[#1A237E] text-white transition-all hover:bg-[#0D1445]">
                    <i class="fas fa-list"></i>
                </button>
                <button class="p-2 rounded-lg border border-gray-200 hover:border-[#1A237E] text-gray-500 hover:text-[#1A237E] transition-all">
                    <i class="fas fa-th"></i>
                </button>
            </div>
        </div>

        <!-- ===== JOB LISTINGS ===== -->
        <div class="space-y-4">
            
            <!-- Job Listing 1 - Featured -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border-l-4 border-l-[#ff7543] border border-gray-100/80 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5 relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-[#ff7543] text-white text-[9px] font-bold px-3 py-1 rounded-bl-lg">Featured</div>
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <!-- Company Logo -->
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors truncate">Senior Frontend Developer</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">TechCorp MY</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Kuala Lumpur
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 2 days ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 8k-12k</span>
                    </div>

                    <!-- Action -->
                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#ff7543] text-gray-400 hover:text-[#ff7543] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listing 2 -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">UX/UI Designer</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">DesignStudio</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Penang
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 3 days ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-3 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 5k-8k</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#1A237E] text-gray-400 hover:text-[#1A237E] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listing 3 -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">DevOps Engineer</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">CloudSystems</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Selangor
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 1 week ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 9k-14k</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#1A237E] text-gray-400 hover:text-[#1A237E] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listing 4 -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">Marketing Manager</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">BrandAgency</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Kuala Lumpur
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 2 weeks ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-3 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 6k-9k</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#1A237E] text-gray-400 hover:text-[#1A237E] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listing 5 -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">Data Analyst</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">DataInsights</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Johor
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 2 weeks ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 5k-8k</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#1A237E] text-gray-400 hover:text-[#1A237E] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Job Listing 6 -->
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#1A237E]/20 transition-all duration-300 p-5 md:p-6 hover:-translate-y-0.5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors truncate">Product Manager</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-sm text-gray-600">InnovateLabs</span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                    Penang
                                </span>
                                <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">Posted 3 weeks ago</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:gap-3">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-3 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1 rounded-full">RM 10k-15k</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="#" class="px-4 py-2 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                            Apply Now
                        </a>
                        <button class="p-2 rounded-xl border border-gray-200 hover:border-[#1A237E] text-gray-400 hover:text-[#1A237E] transition-all">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== PAGINATION ===== -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">Showing <span class="font-semibold text-[#1A237E]">1-6</span> of <span class="font-semibold text-[#1A237E]">24</span> jobs</p>
            <div class="flex items-center gap-1.5">
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button class="px-4 py-1.5 rounded-lg bg-[#1A237E] text-white text-sm font-medium hover:bg-[#0D1445]">1</button>
                <button class="px-4 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">2</button>
                <button class="px-4 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">3</button>
                <button class="px-4 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">4</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</main>

@endsection