<aside id="sidebar" class="fixed top-0 left-0 h-full bg-white border-r border-gray-200 text-gray-700 sidebar-transition z-50 overflow-y-auto overflow-x-hidden shadow-sm"
    style="width: 260px;">

    <!-- Sidebar Content -->
    <div class="flex flex-col h-full">

        <!-- Brand / Logo -->
        <div class="sidebar-brand flex items-center gap-3 px-6 py-5 border-b border-gray-200 sidebar-transition">
            <div class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-xl sm:rounded-2xl overflow-hidden flex-shrink-0">
                <img
                    src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75"
                    alt="SwiftAI Recruit"
                    class="object-contain w-full h-full"
                    onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-sm sm:text-base md:text-xl drop-shadow-sm\'></i>'"
                />
            </div>
            <div class="flex items-baseline sidebar-brand-text">
                <span class="text-base sm:text-xl md:text-xl font-bold text-[#1A237E] whitespace-nowrap">Swift<span class="text-[#FF7543]">AI</span> <span class="text-[#1A237E]">Recruit</span></span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <!-- Label -->
            <p class="sidebar-nav-label text-[10px] text-gray-400 uppercase tracking-wider font-semibold px-3 mb-3">Main Menu</p>

            <!-- Dashboard -->
            <div class="nav-item">
                <a href="{{ route('candidate.dashboard') }}" class="nav-link nav-link-active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#1a237e] bg-blue-50 hover:bg-blue-100 transition-all duration-200 group">
                    <i class="fas fa-th-large w-5 text-center text-sm text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Dashboard</span>
                    <span class="nav-tooltip">Dashboard</span>
                </a>
            </div>

            <!-- ✅ NEW: Resume Manager -->
            <div class="nav-item">
                <a href="{{ route('candidate.resume.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-file-alt w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">My Resume</span>
                    <span class="nav-tooltip">My Resume</span>
                </a>
            </div>

            <!-- ✅ NEW: Job Matches -->
            <div class="nav-item">
                <a href="{{ route('candidate.matches.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-robot w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">My Matches</span>
                    <span class="nav-tooltip">My Matches</span>
                </a>
            </div>

            <!-- Jobs -->
            <div class="nav-item">
                <a href="{{ route('candidate.jobs.listings') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-search w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Find Jobs</span>
                    <span class="nav-tooltip">Find Jobs</span>
                </a>
            </div>

            <!-- Applied Jobs -->
            <div class="nav-item">
                <a href="{{ route('candidate.my-applications') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-briefcase w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Applied Jobs</span>
                    <span class="nav-tooltip">Applied Jobs</span>
                </a>
            </div>

            <!-- Saved Jobs -->
            <div class="nav-item">
                <a href="{{ route('candidate.saved-jobs.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-bookmark w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Saved Jobs</span>
                    <span class="nav-tooltip">Saved Jobs</span>
                </a>
            </div>

            <!-- ✅ NEW: Interview Schedule -->
           

            <!-- Profile -->
            <div class="nav-item">
                <a href="{{ route('candidate.profile') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-user w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Profile</span>
                    <span class="nav-tooltip">Profile</span>
                </a>
            </div>

            <!-- ============================================================ -->
            <!-- DIVIDER -->
            <!-- ============================================================ -->
            <div class="border-t border-gray-200 my-4"></div>
            <p class="sidebar-nav-label text-[10px] text-gray-400 uppercase tracking-wider font-semibold px-3 mb-3">Account</p>

            <!-- Notifications -->
            <div class="nav-item">
                <a href="{{ route('candidate.notifications.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-bell w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Notifications</span>
                    <span class="nav-tooltip">Notifications</span>
                    @if($unreadCount ?? 0 > 0)
                        <span class="nav-badge ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
            </div>

            <!-- Settings -->
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-cog w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Settings</span>
                    <span class="nav-tooltip">Settings</span>
                </a>
            </div>

        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer border-t border-gray-200 px-3 py-4">
            <div class="nav-item">
                <a href="{{ route('auth.user.logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-sign-out-alt w-5 text-center text-sm text-gray-400 group-hover:text-red-500"></i>
                    <span class="sidebar-footer-text text-sm font-medium">Logout</span>
                    <span class="nav-tooltip">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('auth.user.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</aside>