<!-- ============================================================ -->
<!-- HEADER · SwiftAI Recruit Brand Theme                          -->
<!-- ============================================================ -->
<header class="w-full header-glass sticky top-0 z-50 transition-all duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-[72px]">

            <!-- ===== LEFT: Brand ===== -->
            <div class="flex items-center gap-2.5 md:gap-3.5">
                <!-- Logo -->
                <div class="flex items-center justify-center w-9 h-9 md:w-11 md:h-11 rounded-2xl  ring-1 ring-white/30 overflow-hidden">
                    <img 
                        src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75" 
                        alt="SwiftAI Recruit" 
                        class="object-contain"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-base md:text-xl drop-shadow-sm\'></i>'"
                    />
                </div>
                <!-- text -->
                <div class="flex items-baseline">
                    <span class="text-xl md:text-2xl font-bold text-[#1A237E]">Swift<span class="">AI</span> <span class="text-[#1A237E]">Recruit</span></span>
                </div>
            </div>

            <!-- ===== CENTER: Desktop Nav ===== -->
            <nav class="hidden md:flex items-center gap-0.5 lg:gap-1 bg-slate-50/70 p-1 rounded-full border border-slate-200/40 shadow-sm">
                <a href="{{ route('user.home') }}" class="nav-pill text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-2 px-4 py-2 rounded-full">
                    <i class="fas fa-home text-[#FF6B35] text-xs"></i> Home
                </a>
                <a href="{{ route('user.job.listings') }}" class="nav-pill text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-2 px-4 py-2 rounded-full">
                    <i class="fas fa-search text-[#FF6B35] text-xs"></i> Find Jobs
                </a>
                <a href="#" class="nav-pill text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-2 px-4 py-2 rounded-full">
                    <i class="fas fa-building text-[#FF6B35] text-xs"></i> Companies
                </a>
                <a href="#" class="nav-pill text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-white/70 transition-all flex items-center gap-2 px-4 py-2 rounded-full">
                    <i class="fas fa-graduation-cap text-[#FF6B35] text-xs"></i> For Institutions
                </a>
                <a href="#" class="nav-pill text-sm font-medium text-white bg-gradient-to-r from-[#FF6B35] to-[#FF8F65] hover:from-[#E55A2B] hover:to-[#FF6B35] transition-all flex items-center gap-2 px-5 py-2 rounded-full shadow-sm shadow-orange-200/40">
                    <i class="fas fa-rocket text-white/90 text-xs"></i> Post a Job
                </a>
            </nav>

            <!-- ===== RIGHT: Actions + Profile + Mobile toggle ===== -->
            <div class="flex items-center gap-1.5 md:gap-3">

                <!-- desktop actions -->
                <div class="hidden md:flex items-center gap-1">
                    <button class="w-9 h-9 rounded-full hover:bg-slate-100/80 transition-all text-slate-500 hover:text-slate-700 flex items-center justify-center relative">
                        <i class="far fa-bell text-lg"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <button class="w-9 h-9 rounded-full hover:bg-slate-100/80 transition-all text-slate-500 hover:text-slate-700 flex items-center justify-center">
                        <i class="far fa-comment-dots text-lg"></i>
                    </button>
                </div>

                <!-- profile (desktop) -->
                <div class="hidden md:flex items-center gap-2 pl-2 border-l border-slate-200/60">
                    <div class="flex items-center gap-2.5 cursor-pointer group pr-1">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#0B1A33] to-[#1A3A5C] flex items-center justify-center text-white font-semibold text-sm shadow-sm shadow-blue-200/30 ring-2 ring-white/50">
                            SR
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-[#FF6B35] transition-colors">SwiftAI</span>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-[#FF6B35] transition-colors"></i>
                    </div>
                </div>

                <!-- mobile toggle -->
                <button id="mobileMenuToggle" class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-slate-600 hover:bg-slate-100/70 transition-all focus:outline-none focus:ring-2 focus:ring-[#FF6B35]/60" aria-label="open menu">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== MOBILE MENU (collapsible) ===== -->
    <div id="mobileMenu" class="mobile-menu hidden md:hidden bg-white/95 backdrop-blur-lg border-t border-slate-200/60 px-5 pb-5 pt-3 shadow-2xl rounded-b-3xl">
        <div class="flex flex-col space-y-1.5">

            <!-- profile row -->
            <div class="flex items-center gap-3 px-2 py-2.5 border-b border-slate-200/70 mb-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#0B1A33] to-[#1A3A5C] flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-white/50">
                    SR
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">SwiftAI Recruit</p>
                    <p class="text-xs text-slate-500">hello@swiftairecruit.com</p>
                </div>
                <span class="ml-auto text-[10px] font-semibold bg-[#FF6B35]/10 text-[#FF6B35] px-2.5 py-0.5 rounded-full border border-[#FF6B35]/20">AI</span>
            </div>

            <!-- nav links -->
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover">
                <i class="fas fa-home text-[#FF6B35] w-5 text-center"></i> Home
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover">
                <i class="fas fa-search text-[#FF6B35] w-5 text-center"></i> Find Jobs
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover">
                <i class="fas fa-building text-[#FF6B35] w-5 text-center"></i> Companies
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:bg-orange-50/70 transition-all nav-link-hover">
                <i class="fas fa-graduation-cap text-[#FF6B35] w-5 text-center"></i> For Institutions
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white bg-gradient-to-r from-[#FF6B35] to-[#FF8F65] hover:from-[#E55A2B] hover:to-[#FF6B35] transition-all shadow-md">
                <i class="fas fa-rocket text-white/90 w-5 text-center"></i> Post a Job
            </a>

            <!-- action buttons -->
            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-slate-200/70">
                <button class="flex items-center gap-2 text-sm text-slate-600 hover:text-[#FF6B35] transition-colors">
                    <i class="far fa-bell text-base"></i> Alerts
                </button>
                <button class="flex items-center gap-2 text-sm text-slate-600 hover:text-[#FF6B35] transition-colors">
                    <i class="far fa-comment-dots text-base"></i> Messages
                </button>
                <button class="ml-auto text-sm text-rose-500/80 hover:text-rose-600 transition-colors flex items-center gap-1.5">
                    <i class="fas fa-sign-out-alt text-sm"></i> Logout
                </button>
            </div>
        </div>
    </div>
</header>


