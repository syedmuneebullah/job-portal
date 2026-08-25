@extends('user.layouts.app')
@section('content')
<!-- ============================================================ -->
<!-- HERO SECTION · Balanced Malaysian Theme                       -->
<!-- ============================================================ -->
<main>
    <section class="relative w-full min-h-[44rem] overflow-hidden" id="home">

        <img
            src="{{ asset('user-assets/background/Hero11.jpg') }}"
            alt="Hero Background"
            class="absolute top-0 left-0 w-full h-full object-cover z-0"
        />

        <!-- Legibility scrim -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/15 via-white/55 to-white/85 z-[1]"></div>

        <div class="relative z-10 w-full flex flex-col items-center justify-center px-4 md:px-12 mt-8 pb-10 text-black">

            <!-- Eyebrow -->
            <div class="hero-fade inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm border border-[#ff7543]/20 text-[#ff7543] text-xs font-semibold tracking-wide px-4 py-1.5 rounded-full mt-16 shadow-sm" style="animation-delay:.05s">
                <span class="relative flex h-2 w-2">
                    <span class="motion-safe:animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ff7543] opacity-60"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ff7543]"></span>
                </span>
                Trusted by 500+ companies in Malaysia & beyond
            </div>

            <h1 class="hero-fade text-4xl md:text-5xl font-bold text-[#1A237E] max-w-4xl leading-[1.08] tracking-tight mb-6 text-center mt-6" style="animation-delay:.15s">
                Transforming Recruitment with Intelligence.
                <span class="bg-gradient-to-r from-[#ff7543] to-[#FF8A65] bg-clip-text text-transparent">Empowering Careers.</span>
            </h1>

            <!-- ===== SEARCH BAR ===== -->
            <div class="hero-fade mt-2 mx-auto w-full px-2 max-w-5xl" style="animation-delay:.25s">
                <form
                    id="heroSearchForm"
                    role="search"
                    aria-label="Search jobs"
                    method="GET"
                    action=""
                    class="relative w-full flex flex-col bg-white/95 backdrop-blur-sm border border-gray-200/60 rounded-2xl md:rounded-full overflow-hidden p-2 shadow-2xl shadow-gray-200/50 focus-within:ring-2 focus-within:ring-[#ff7543]/30 transition-all"
                >
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-1">

                        <!-- Search input -->
                        <div class="flex-1 flex items-center gap-2 px-3 min-w-[200px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 shrink-0">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                            <label for="searchInput" class="sr-only">Job title or company</label>
                            <input
                                id="searchInput"
                                name="search"
                                type="text"
                                placeholder="Job title or company..."
                                class="w-full py-2.5 md:py-2 text-sm text-gray-700 bg-transparent outline-none border-none focus:ring-0 placeholder-gray-400"
                                value=""
                            />
                        </div>

                        <!-- Mobile filter toggle -->
                        <button
                            type="button"
                            id="filterToggle"
                            aria-expanded="false"
                            aria-controls="locationFilters"
                            class="md:hidden flex items-center justify-center gap-2 text-sm font-semibold text-[#ff7543] px-3 py-2.5 border-t border-gray-100"
                        >
                            <span id="filterToggleLabel">More filters</span>
                            <svg id="filterChevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                        </button>

                        <!-- Country, State, City, Salary, Job Type -->
                        <div id="locationFilters" class="grid grid-cols-1 md:grid-cols-5 gap-3 w-full py-0 px-3 md:px-0 max-h-0 opacity-0 overflow-hidden md:max-h-none md:opacity-100 transition-all duration-300 ease-in-out">

                            <div>
                                <label for="countrySelect" class="sr-only">Country</label>
                                <select id="countrySelect" name="country" class="w-full px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all">
                                    <option value="">Country</option>
                                    <option value="malaysia">Malaysia</option>
                                    <option value="singapore">Singapore</option>
                                    <option value="thailand">Thailand</option>
                                    <option value="indonesia">Indonesia</option>
                                    <option value="philippines">Philippines</option>
                                    <option value="vietnam">Vietnam</option>
                                    <option value="usa">USA</option>
                                    <option value="uk">UK</option>
                                </select>
                            </div>

                            <div>
                                <label for="stateSelect" class="sr-only">State</label>
                                <select id="stateSelect" name="state" class="w-full px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all">
                                    <option value="">State</option>
                                    <option value="selangor">Selangor</option>
                                    <option value="kl">Kuala Lumpur</option>
                                    <option value="penang">Penang</option>
                                    <option value="johor">Johor</option>
                                    <option value="sarawak">Sarawak</option>
                                    <option value="sabah">Sabah</option>
                                    <option value="perak">Perak</option>
                                    <option value="kedah">Kedah</option>
                                </select>
                            </div>

                            <div>
                                <label for="citySelect" class="sr-only">City</label>
                                <select id="citySelect" name="city" class="w-full px-3 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all">
                                    <option value="">City</option>
                                    <option value="kl">Kuala Lumpur</option>
                                    <option value="pj">Petaling Jaya</option>
                                    <option value="shahalam">Shah Alam</option>
                                    <option value="georgetown">George Town</option>
                                    <option value="jb">Johor Bahru</option>
                                    <option value="ipoh">Ipoh</option>
                                    <option value="kuching">Kuching</option>
                                    <option value="kk">Kota Kinabalu</option>
                                </select>
                            </div>

                            <div>
                                <label for="salarySelect" class="sr-only">Salary</label>
                                <select id="salarySelect" name="salary" class="w-full px-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all">
                                    <option value="">Salary (RM)</option>
                                    <option value="3k-5k">RM 3k - 5k</option>
                                    <option value="5k-8k">RM 5k - 8k</option>
                                    <option value="8k-12k">RM 8k - 12k</option>
                                    <option value="12k+">RM 12k+</option>
                                </select>
                            </div>

                            <div>
                                <label for="jobTypeSelect" class="sr-only">Job Type</label>
                                <select id="jobTypeSelect" name="jobType" class="w-full px-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all">
                                    <option value="">Job Type</option>
                                    <option value="fulltime">Full-time</option>
                                    <option value="parttime">Part-time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search button -->
                        <button
                            id="searchButton"
                            type="submit"
                            class="flex justify-center items-center gap-2 bg-[#ff7543] hover:bg-[#B71C1C] active:scale-[0.98] transition-all text-white text-sm font-semibold py-3 px-6 rounded-xl md:rounded-full flex-shrink-0 mt-2 md:mt-0"
                        >
                            <span class="uppercase tracking-wider">Find Jobs</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="14px" class="fill-white">
                                <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Popular searches -->
                <div class="flex flex-wrap items-center justify-center gap-2 mt-3">
                    <span class="text-xs text-gray-500/90 font-medium mr-1">Popular:</span>
                    @foreach (['Remote', 'Software Engineer', 'Marketing', 'KL'] as $tag)
                        <button type="button" class="popular-tag text-xs font-medium text-[#ff7543] bg-white/70 hover:bg-white border border-gray-200/60 px-3 py-1.5 rounded-full transition-colors">
                            {{ $tag }}
                        </button>
                    @endforeach
                </div>
            </div>

           <!-- ===== STATS - Hidden on Mobile ===== -->
            <div class="hero-fade mt-16 hidden sm:flex sm:flex-wrap sm:justify-center sm:grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-8" style="animation-delay:.35s">

                <div class="flex items-center gap-3 sm:gap-4 justify-center text-black flex-1 min-w-[120px] sm:min-w-0">
                    <div class="bg-gray-100/70 p-3 sm:p-5 rounded-full text-[#1A237E] text-sm sm:text-lg md:text-xl transition-transform duration-300 hover:scale-105 flex-shrink-0">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"></path>
                        </svg>
                    </div>
                    <div class="text-center sm:text-left text-sm md:text-base">
                        <p class="font-bold text-base sm:text-lg md:text-xl text-[#1A237E]"><span class="stat-count" data-count-to="4700">0</span>+</p>
                        <span class="font-semibold text-[10px] sm:text-xs md:text-sm text-gray-600">Jobs</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 justify-center text-black flex-1 min-w-[120px] sm:min-w-0">
                    <div class="bg-gray-100/70 p-3 sm:p-5 rounded-full text-[#1A237E] text-sm sm:text-lg md:text-xl transition-transform duration-300 hover:scale-105 flex-shrink-0">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M436 480h-20V24c0-13.255-10.745-24-24-24H56C42.745 0 32 10.745 32 24v456H12c-6.627 0-12 5.373-12 12v20h448v-20c0-6.627-5.373-12-12-12zM128 76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76zm0 96c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40zm52 148h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12zm76 160h-64v-84c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v84zm64-172c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40z"></path>
                        </svg>
                    </div>
                    <div class="text-center sm:text-left text-sm md:text-base">
                        <p class="font-bold text-base sm:text-lg md:text-xl text-[#1A237E]"><span class="stat-count" data-count-to="500">0</span>+</p>
                        <span class="font-semibold text-[10px] sm:text-xs md:text-sm text-gray-600">Companies</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 justify-center text-black flex-1 min-w-[120px] sm:min-w-0">
                    <div class="bg-gray-100/70 p-3 sm:p-5 rounded-full text-[#1A237E] text-sm sm:text-lg md:text-xl transition-transform duration-300 hover:scale-105 flex-shrink-0">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"></path>
                        </svg>
                    </div>
                    <div class="text-center sm:text-left text-sm md:text-base">
                        <p class="font-bold text-base sm:text-lg md:text-xl text-[#1A237E]"><span class="stat-count" data-count-to="10000">0</span>+</p>
                        <span class="font-semibold text-[10px] sm:text-xs md:text-sm text-gray-600">Candidates</span>
                    </div>
                </div>
            </div>

            <!-- ===== QUICK LINKS - Hidden on Mobile ===== -->
            <div class="hero-fade mt-6 hidden sm:flex sm:flex-wrap sm:justify-center sm:grid sm:grid-cols-3 gap-2 sm:gap-4 bg-white/30 backdrop-blur-2xl p-3 sm:p-4 rounded-2xl shadow-xl border border-white/40 max-w-5xl mx-auto" style="animation-delay:.45s">

                <a class="flex-1 min-w-[140px] sm:min-w-0 block group" href="/resource-on-demand">
                    <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-6 py-2.5 sm:py-4 rounded-xl text-sm font-bold border border-transparent bg-white/40 text-[#1A237E] transition-all duration-300 hover:border-[#ff7543]/30 hover:bg-white/60 hover:shadow-lg">
                        <div class="w-7 h-7 sm:w-9 sm:h-9 shrink-0 rounded-full bg-[#ff7543]/10 flex items-center justify-center text-[#ff7543] group-hover:bg-[#ff7543] group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 21a8 8 0 0 1 13.292-6"></path>
                                <circle cx="10" cy="8" r="5"></circle>
                                <path d="m16 19 2 2 4-4"></path>
                            </svg>
                        </div>
                        <span class="flex-1 text-[9px] sm:text-xs md:text-sm leading-tight font-semibold text-center sm:text-left">Resource On Demand</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 shrink-0 hidden sm:block">
                            <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <a class="flex-1 min-w-[140px] sm:min-w-0 block group" href="/resource-augmentation">
                    <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-6 py-2.5 sm:py-4 rounded-xl text-sm font-bold border border-transparent bg-white/40 text-[#1A237E] transition-all duration-300 hover:border-[#ff7543]/30 hover:bg-white/60 hover:shadow-lg">
                        <div class="w-7 h-7 sm:w-9 sm:h-9 shrink-0 rounded-full bg-[#ff7543]/10 flex items-center justify-center text-[#ff7543] group-hover:bg-[#ff7543] group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 21a8 8 0 0 0-16 0"></path>
                                <circle cx="10" cy="8" r="5"></circle>
                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path>
                            </svg>
                        </div>
                        <span class="flex-1 text-[9px] sm:text-xs md:text-sm leading-tight font-semibold text-center sm:text-left">Resource Augmentation</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 shrink-0 hidden sm:block">
                            <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <a class="flex-1 min-w-[140px] sm:min-w-0 block group" href="/campus-connect">
                    <div class="flex items-center gap-2 sm:gap-3 px-2 sm:px-6 py-2.5 sm:py-4 rounded-xl text-sm font-bold border border-transparent bg-white/40 text-[#1A237E] transition-all duration-300 hover:border-[#ff7543]/30 hover:bg-white/60 hover:shadow-lg">
                        <div class="w-7 h-7 sm:w-9 sm:h-9 shrink-0 rounded-full bg-[#ff7543]/10 flex items-center justify-center text-[#ff7543] group-hover:bg-[#ff7543] group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                <path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path>
                            </svg>
                        </div>
                        <span class="flex-1 text-[9px] sm:text-xs md:text-sm leading-tight font-semibold text-center sm:text-left">Campus Connect</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 shrink-0 hidden sm:block">
                            <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- JOB LISTINGS SECTION                                          -->
    <!-- ============================================================ -->
    <section class="relative w-full py-16 md:py-20 bg-gradient-to-b from-white via-slate-50/50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-10 md:mb-14">
                <span class="inline-block text-xs font-semibold text-[#ff7543] bg-[#ff7543]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                    Latest Opportunities
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-[#1A237E] mb-3">
                    Featured <span class="text-[#ff7543]">Jobs</span>
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                    Discover your next career move. Handpicked opportunities from top Malaysian companies.
                </p>
            </div>

            <!-- Job Listings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                
                <!-- Job Card 1 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">Senior Frontend Developer</h3>
                            <p class="text-sm text-gray-500 truncate">TechCorp MY · KL</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 8k-12k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 2 days ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Job Card 2 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">UX/UI Designer</h3>
                            <p class="text-sm text-gray-500 truncate">DesignStudio · Penang</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-2.5 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 5k-8k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 3 days ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Job Card 3 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">DevOps Engineer</h3>
                            <p class="text-sm text-gray-500 truncate">CloudSystems · Selangor</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 9k-14k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 1 week ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Job Card 4 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">Marketing Manager</h3>
                            <p class="text-sm text-gray-500 truncate">BrandAgency · KL</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-2.5 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 6k-9k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 2 weeks ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Job Card 5 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">Data Analyst</h3>
                            <p class="text-sm text-gray-500 truncate">DataInsights · Johor</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 5k-8k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 2 weeks ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Job Card 6 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 hover:border-[#ff7543]/30 transition-all duration-300 p-5 md:p-6 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-xl font-bold shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                <circle cx="10" cy="12" r="1"></circle>
                                <circle cx="14" cy="12" r="1"></circle>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#ff7543] transition-colors">Product Manager</h3>
                            <p class="text-sm text-gray-500 truncate">InnovateLabs · Penang</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-2.5 py-1 rounded-full">Hybrid</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">RM 10k-15k</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">Posted 3 weeks ago</span>
                        <a href="#" class="text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors flex items-center gap-1">
                            Apply Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- View All Jobs Button -->
            <div class="text-center mt-10 md:mt-12">
                <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#1A237E] hover:bg-[#0D1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1A237E]/20 hover:shadow-xl hover:shadow-[#1A237E]/30 hover:-translate-y-0.5">
                    <span>View All Jobs</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- BROWSE BY CATEGORY SECTION                                   -->
    <!-- ============================================================ -->
    <section class="relative py-16 bg-white overflow-hidden" id="browse">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gray-50/50 skew-x-12 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute top-40 left-10 w-64 h-64 bg-gray-100/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 right-1/4 w-96 h-96 bg-gray-100/30 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 lg:mb-16 gap-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100/70 text-[#1A237E] text-[10px] font-bold uppercase tracking-widest mb-4 border border-gray-200/60">
                        <span class="w-2 h-2 rounded-full bg-[#ff7543] animate-pulse"></span>
                        Browse Categories
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#1A237E] mb-3 tracking-tight">
                        Explore <span class="text-[#ff7543]">Opportunities</span> by Category
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Find your perfect role across industries and specializations in Malaysia.
                    </p>
                </div>
                
                <!-- Stats -->
                <div class="hidden lg:flex items-center gap-8 border-l border-gray-100 pl-8 h-16">
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-[#1A237E]">25+</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Categories</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-black text-[#1A237E]">500+</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Specializations</div>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid lg:grid-cols-12 gap-6 md:gap-8 items-start">
                
                <!-- Left Side - Category Tags -->
                <div class="lg:col-span-6 order-2 lg:order-1">
                    <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-2xl shadow-gray-100/50 border border-gray-50 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gray-100/50 rounded-full translate-x-1/2 -translate-y-1/2 transition-transform duration-700 group-hover:scale-150"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-5 md:mb-7">
                                <div class="h-1.5 w-10 bg-[#ff7543] rounded-full"></div>
                                <h3 class="text-base sm:text-lg md:text-xl font-bold text-[#1A237E] uppercase tracking-wider">Popular Categories</h3>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 md:gap-3">
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Software Engineer (15)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Graphic Designer (10)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Financial Analyst (8)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">HR Manager (12)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Business Analyst (9)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Web Developer (14)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Marketing Specialist (7)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Data Scientist (11)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Product Manager (6)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">UI/UX Designer (5)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Sales Executive (13)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Project Manager (10)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Content Writer (8)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">DevOps Engineer (9)</span>
                                </a>
                                <a href="#" class="px-3 sm:px-4 py-[6px] bg-gray-50 text-gray-700 rounded-full text-xs sm:text-sm font-bold hover:bg-[#1A237E] hover:text-white hover:shadow-xl hover:shadow-[#1A237E]/20 transition-all duration-300 border border-gray-100 hover:border-[#1A237E] group/tag">
                                    <span class="relative flex items-center gap-1.5">Cybersecurity Expert (7)</span>
                                </a>
                            </div>
                            
                            <!-- View All Link -->
                            <div class="mt-5 md:mt-6 pt-4 border-t border-gray-100">
                                <a href="#" class="inline-flex items-center gap-2 text-sm font-semibold text-[#ff7543] hover:text-[#B71C1C] transition-colors">
                                    <span>View All Categories</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Category Cards -->
                <div class="lg:col-span-6 order-1 lg:order-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
                        
                        <!-- Category 1: Software -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M592 0H48A48 48 0 0 0 0 48v320a48 48 0 0 0 48 48h240v32H112a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16H352v-32h240a48 48 0 0 0 48-48V48a48 48 0 0 0-48-48zm-16 352H64V64h512z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">Software</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">50 Active Positions</p>
                                </div>
                            </div>
                        </a>

                        <!-- Category 2: Design -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">Design</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">30 Active Positions</p>
                                </div>
                            </div>
                        </a>

                        <!-- Category 3: Finance -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M608 64H32C14.33 64 0 78.33 0 96v320c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V96c0-17.67-14.33-32-32-32zM48 400v-64c35.35 0 64 28.65 64 64H48zm0-224v-64h64c0 35.35-28.65 64-64 64zm272 176c-44.19 0-80-42.99-80-96 0-53.02 35.82-96 80-96s80 42.98 80 96c0 53.03-35.83 96-80 96zm272 48h-64c0-35.35 28.65-64 64-64v64zm0-224c-35.35 0-64-28.65-64-64h64v64z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">Finance</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">25 Active Positions</p>
                                </div>
                            </div>
                        </a>

                        <!-- Category 4: HR -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">HR</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">20 Active Positions</p>
                                </div>
                            </div>
                        </a>

                        <!-- Category 5: Business -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">Business</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">35 Active Positions</p>
                                </div>
                            </div>
                        </a>

                        <!-- Category 6: Marketing -->
                        <a href="#" class="group bg-white px-4 sm:px-5 py-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 flex flex-col gap-3 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 via-gray-50/0 to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-gray-100/70 text-[#1A237E] rounded-2xl flex items-center justify-center group-hover:bg-[#1A237E] group-hover:text-white group-hover:rotate-12 transition-all duration-500 shadow-inner">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M320 336c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h416c25.6 0 48-22.4 48-48V288H320v48zm144-208h-80V80c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h512v-80c0-25.6-22.4-48-48-48zm-144 0H192V96h128v32z"></path>
                                    </svg>
                                </div>
                                <span class="text-[9px] sm:text-[10px] font-black text-[#ff7543] bg-red-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-widest border border-red-100">Trending</span>
                            </div>
                            <div class="relative z-10">
                                <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-0.5 group-hover:text-[#1A237E] transition-colors">Marketing</h4>
                                <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <p class="text-[11px] sm:text-[12px] text-gray-400 font-bold uppercase tracking-wide">15 Active Positions</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- COMPANIES SECTION - Malaysian Market                         -->
    <!-- ============================================================ -->
    <section class="relative w-full py-16 md:py-20 bg-gradient-to-b from-slate-50/50 via-white to-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-10 md:mb-14">
                <span class="inline-block text-xs font-semibold text-[#ff7543] bg-[#ff7543]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                    Top Malaysian Companies
                </span>
                <h2 class="text-2xl md:text-4xl font-bold text-[#1A237E] mb-3 leading-tight">
                    Discover Opportunities at <br class="hidden sm:block">
                    <span class="text-[#ff7543]">Leading Companies</span> That Inspire Growth
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                    Join thousands of professionals working at Malaysia's most innovative companies.
                </p>
            </div>

            <!-- Companies Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                
                <!-- Company 1 - Petronas -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">P</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Petronas</h3>
                    <p class="text-xs text-gray-500 mt-1">15 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">KL</span>
                        <span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">Full-time</span>
                    </div>
                </div>

                <!-- Company 2 - Maybank -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">M</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Maybank</h3>
                    <p class="text-xs text-gray-500 mt-1">10 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Hybrid</span>
                        <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">Finance</span>
                    </div>
                </div>

                <!-- Company 3 - AirAsia -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">A</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">AirAsia</h3>
                    <p class="text-xs text-gray-500 mt-1">20 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Remote</span>
                        <span class="text-[10px] bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full">Urgent</span>
                    </div>
                </div>

                <!-- Company 4 - CIMB -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">C</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">CIMB</h3>
                    <p class="text-xs text-gray-500 mt-1">8 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">KL</span>
                        <span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">Full-time</span>
                    </div>
                </div>

                <!-- Company 5 - Grab -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">G</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Grab</h3>
                    <p class="text-xs text-gray-500 mt-1">12 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Remote</span>
                        <span class="text-[10px] bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full">Tech</span>
                    </div>
                </div>

                <!-- Company 6 - Maxis -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">M</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Maxis</h3>
                    <p class="text-xs text-gray-500 mt-1">6 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Hybrid</span>
                        <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">Telecom</span>
                    </div>
                </div>

                <!-- Company 7 - Tenaga -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">T</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Tenaga Nasional</h3>
                    <p class="text-xs text-gray-500 mt-1">9 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">On-site</span>
                        <span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">Energy</span>
                    </div>
                </div>

                <!-- Company 8 - Shopee -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">S</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Shopee</h3>
                    <p class="text-xs text-gray-500 mt-1">18 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Remote</span>
                        <span class="text-[10px] bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full">E-commerce</span>
                    </div>
                </div>

                <!-- Company 9 - Public Bank -->
                <div class="group bg-white rounded-2xl p-6 md:p-8 text-center border border-gray-100/80 hover:border-[#ff7543]/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-[#1A237E]">P</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Public Bank</h3>
                    <p class="text-xs text-gray-500 mt-1">7 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">KL</span>
                        <span class="text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">Banking</span>
                    </div>
                </div>

                <!-- Company 10 - Featured -->
                <div class="group bg-gradient-to-br from-[#ff7543]/5 to-[#ff7543]/10 rounded-2xl p-6 md:p-8 text-center border-2 border-[#ff7543]/20 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#ff7543] text-white text-[9px] font-bold px-3 py-1 rounded-bl-lg">Featured</div>
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gradient-to-br from-[#1A237E] to-[#0D1445] flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-2xl md:text-3xl font-bold text-white">G</span>
                    </div>
                    <h3 class="text-sm md:text-base font-bold text-gray-900 group-hover:text-[#ff7543] transition-colors">Genting</h3>
                    <p class="text-xs text-gray-500 mt-1">12 openings</p>
                    <div class="mt-3 flex justify-center gap-1">
                        <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">On-site</span>
                        <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">Hospitality</span>
                    </div>
                </div>
            </div>

            <!-- View All Companies Button -->
            <div class="text-center mt-10 md:mt-12">
                <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white hover:bg-gray-50 text-[#1A237E] font-semibold rounded-xl border-2 border-[#1A237E] transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <span>View All Companies</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</main>

<style>
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .hero-fade {
        opacity: 0;
        animation: heroFadeUp .6s ease-out forwards;
    }
    @media (prefers-reduced-motion: reduce) {
        .hero-fade { animation: none; opacity: 1; }
        .motion-safe\:animate-ping { animation: none; }
    }
</style>

<script>
(function () {
    // ---- Mobile "More filters" toggle ----
    const toggle = document.getElementById('filterToggle');
    const panel = document.getElementById('locationFilters');
    const chevron = document.getElementById('filterChevron');
    const label = document.getElementById('filterToggleLabel');

    if (toggle && panel) {
        toggle.addEventListener('click', function () {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
            panel.classList.toggle('max-h-0', isOpen);
            panel.classList.toggle('opacity-0', isOpen);
            panel.classList.toggle('max-h-[400px]', !isOpen);
            panel.classList.toggle('opacity-100', !isOpen);
            panel.classList.toggle('py-3', !isOpen);
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            label.textContent = isOpen ? 'More filters' : 'Hide filters';
        });
    }

    // ---- Popular search tags ----
    document.querySelectorAll('.popular-tag').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById('searchInput');
            if (input) {
                input.value = btn.textContent.trim();
                input.focus();
            }
        });
    });

    // ---- Stat count-up on scroll into view ----
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const counters = document.querySelectorAll('.stat-count');

    function animateCount(el) {
        const target = parseInt(el.dataset.countTo, 10) || 0;
        if (prefersReducedMotion) {
            el.textContent = target.toLocaleString();
            return;
        }
        const duration = 1200;
        const start = performance.now();
        function tick(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    if ('IntersectionObserver' in window && counters.length) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (c) { observer.observe(c); });
    } else {
        counters.forEach(animateCount);
    }
})();
</script>
@endsection