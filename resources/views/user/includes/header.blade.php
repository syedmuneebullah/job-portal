<!-- ============================================================ -->
<!-- HEADER · SwiftAI Recruit Brand Theme                          -->
<!-- ============================================================ -->
<header class="w-full header-glass sticky top-0 z-50 transition-all duration-200">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16 md:h-[72px]">

            <!-- ===== LEFT: Brand ===== -->
            <div class="flex items-center gap-2 sm:gap-2.5 md:gap-3.5">
                <!-- Logo -->
                <div class="flex items-center justify-center w-7 h-7 sm:w-9 sm:h-9 md:w-11 md:h-11 rounded-xl sm:rounded-2xl ring-1 ring-white/30 overflow-hidden flex-shrink-0">
                    <img
                        src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75"
                        alt="SwiftAI Recruit"
                        class="object-contain w-full h-full"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-sm sm:text-base md:text-xl drop-shadow-sm\'></i>'"
                    />
                </div>
                <!-- text -->
                <div class="flex items-baseline">
                    <span class="text-base sm:text-xl md:text-2xl font-bold text-[#1A237E] whitespace-nowrap">Swift<span class="">AI</span> <span class="text-[#1A237E] ">Recruit</span></span>
                </div>
            </div>

            <!-- ===== CENTER: Desktop Nav ===== -->
            <nav class="hidden lg:flex items-center gap-0.5 xl:gap-1 bg-slate-50/70 p-1 rounded-full border border-slate-200/40 shadow-sm">
                <a href="{{ route('user.home') }}" class="nav-pill text-xs xl:text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-1.5 xl:gap-2 px-3 xl:px-4 py-1.5 xl:py-2 rounded-full">
                    <i class="fas fa-home text-[#FF6B35] text-[10px] xl:text-xs"></i> Home
                </a>
                <a href="{{ route('user.job.listings') }}" class="nav-pill text-xs xl:text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-1.5 xl:gap-2 px-3 xl:px-4 py-1.5 xl:py-2 rounded-full">
                    <i class="fas fa-search text-[#FF6B35] text-[10px] xl:text-xs"></i> Find Jobs
                </a>
                <a href="#" class="nav-pill text-xs xl:text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-1.5 xl:gap-2 px-3 xl:px-4 py-1.5 xl:py-2 rounded-full">
                    <i class="fas fa-building text-[#FF6B35] text-[10px] xl:text-xs"></i> Companies
                </a>
                <a href="#" class="nav-pill text-xs xl:text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-1.5 xl:gap-2 px-3 xl:px-4 py-1.5 xl:py-2 rounded-full">
                    <i class="fas fa-graduation-cap text-[#FF6B35] text-[10px] xl:text-xs"></i> Institutions
                </a>
                <a href="#" class="nav-pill text-xs xl:text-sm font-medium text-white bg-gradient-to-r from-[#FF6B35] to-[#FF8F65] hover:from-[#E55A2B] hover:to-[#FF6B35] transition-all flex items-center gap-1.5 xl:gap-2 px-3 xl:px-5 py-1.5 xl:py-2 rounded-full shadow-sm shadow-orange-200/40">
                    <i class="fas fa-rocket text-white/90 text-[10px] xl:text-xs"></i> Post a Job
                </a>
            </nav>

            <!-- ===== RIGHT: Actions + Get Hired + Create Vacancies ===== -->
            <div class="flex items-center gap-1 sm:gap-1.5 md:gap-3">

                <!-- desktop actions (hidden on smaller screens) -->
                {{-- <div class="hidden sm:flex items-center gap-0.5 md:gap-1">
                    <button class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full hover:bg-slate-100/80 transition-all text-slate-500 hover:text-slate-700 flex items-center justify-center relative">
                        <i class="far fa-bell text-sm sm:text-base md:text-lg"></i>
                        <span class="absolute top-1 right-1 w-1.5 h-1.5 sm:w-2 sm:h-2 bg-rose-500 rounded-full ring-1 sm:ring-2 ring-white"></span>
                    </button>
                    <button class="hidden md:flex w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full hover:bg-slate-100/80 transition-all text-slate-500 hover:text-slate-700 items-center justify-center">
                        <i class="far fa-comment-dots text-sm sm:text-base md:text-lg"></i>
                    </button>
                </div> --}}

                <!-- ===== Get Hired & Create Vacancies Buttons (small & responsive) ===== -->
                <div class="hidden sm:flex items-center gap-1 md:gap-2">
                    <a href="{{route('auth.user.login')}}" class="flex items-center gap-1 md:gap-2 px-2.5 sm:px-3 md:px-4 py-1.5 sm:py-1.5 md:py-2 rounded-full border-2 border-[#FF6B35] text-[#FF6B35] font-semibold text-[10px] sm:text-xs md:text-sm hover:bg-[#FF6B35] hover:text-white transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-user-plus text-[10px] sm:text-xs md:text-sm"></i>
                        <span class="hidden xs:inline">Get Hired</span>
                        <span class="xs:hidden">Get Hired</span>
                    </a>
                    <a href="{{route('auth.user.register')}}" class="flex items-center gap-1 md:gap-2 px-2.5 sm:px-3 md:px-4 py-1.5 sm:py-1.5 md:py-2 rounded-full bg-gradient-to-r from-[#1A237E] to-[#2A3F8A] text-white font-semibold text-[10px] sm:text-xs md:text-sm hover:from-[#0F1A5E] hover:to-[#1A237E] transition-all duration-200 shadow-md shadow-blue-200/30 whitespace-nowrap">
                        <i class="fas fa-plus-circle text-[10px] sm:text-xs md:text-sm"></i>
                        <span class="hidden xs:inline">Create Vacancies</span>
                        <span class="xs:hidden">Create Vacancies</span>
                    </a>
                </div>

                <!-- mobile toggle -->
                <button id="mobileMenuToggle" class="lg:hidden w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full flex items-center justify-center text-slate-600 hover:bg-slate-100/70 transition-all focus:outline-none focus:ring-2 focus:ring-[#FF6B35]/60" aria-label="open menu">
                    <i class="fas fa-bars text-base sm:text-lg md:text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== MOBILE MENU (collapsible) ===== -->
    <div id="mobileMenu" class="mobile-menu hidden lg:hidden bg-white/95 backdrop-blur-lg border-t border-slate-200/60 px-4 sm:px-5 pb-4 sm:pb-5 pt-2 sm:pt-3 shadow-2xl rounded-b-2xl sm:rounded-b-3xl">
        <div class="flex flex-col space-y-1 sm:space-y-1.5">

            <!-- action buttons row (mobile) -->
            <div class="flex items-center gap-2 px-1 sm:px-2 py-2 sm:py-2.5 border-b border-slate-200/70 mb-1">
                <a href="#" class="flex-1 flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 rounded-xl border-2 border-[#FF6B35] text-[#FF6B35] font-semibold text-[11px] sm:text-sm hover:bg-[#FF6B35] hover:text-white transition-all duration-200">
                    <i class="fas fa-user-plus text-[11px] sm:text-sm"></i> Get Hired
                </a>
                <a href="#" class="flex-1 flex items-center justify-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1.5 sm:py-2 rounded-xl bg-gradient-to-r from-[#1A237E] to-[#2A3F8A] text-white font-semibold text-[11px] sm:text-sm hover:from-[#0F1A5E] hover:to-[#1A237E] transition-all duration-200">
                    <i class="fas fa-plus-circle text-[11px] sm:text-sm"></i> Create
                </a>
            </div>

            <!-- nav links -->
            <a href="#" class="flex items-center gap-3 px-3 py-2 sm:py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover text-sm sm:text-base">
                <i class="fas fa-home text-[#FF6B35] w-5 text-center"></i> Home
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 sm:py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover text-sm sm:text-base">
                <i class="fas fa-search text-[#FF6B35] w-5 text-center"></i> Find Jobs
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 sm:py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover text-sm sm:text-base">
                <i class="fas fa-building text-[#FF6B35] w-5 text-center"></i> Companies
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 sm:py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover text-sm sm:text-base">
                <i class="fas fa-graduation-cap text-[#FF6B35] w-5 text-center"></i> For Institutions
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 sm:py-2.5 rounded-xl text-white bg-gradient-to-r from-[#FF6B35] to-[#FF8F65] hover:from-[#E55A2B] hover:to-[#FF6B35] transition-all shadow-md text-sm sm:text-base">
                <i class="fas fa-rocket text-white/90 w-5 text-center"></i> Post a Job
            </a>

            <!-- notification & messages -->
            <div class="flex items-center gap-4 mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-slate-200/70">
                <button class="flex items-center gap-2 text-xs sm:text-sm text-slate-600 hover:text-[#FF6B35] transition-colors">
                    <i class="far fa-bell text-sm sm:text-base"></i> Alerts
                </button>
                <button class="flex items-center gap-2 text-xs sm:text-sm text-slate-600 hover:text-[#FF6B35] transition-colors">
                    <i class="far fa-comment-dots text-sm sm:text-base"></i> Messages
                </button>
            </div>
        </div>
    </div>
</header>
