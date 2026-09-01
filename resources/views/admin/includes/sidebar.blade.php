<aside id="sidebar" class="fixed top-0 left-0 h-full bg-white border-r border-gray-200 text-gray-700 sidebar-transition z-50 overflow-y-auto overflow-x-hidden shadow-sm"
    style="width: 260px;">
            
    <!-- Sidebar Content -->
    <div class="flex flex-col h-full">
        
        <!-- Brand / Logo -->
        <div class="sidebar-brand flex items-center gap-3 px-6 py-5 border-b border-gray-200 sidebar-transition">
            <div class="flex items-center justify-center w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 rounded-xl sm:rounded-2xl  overflow-hidden flex-shrink-0">
                <img
                        src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75"
                        alt="SwiftAI Recruit"
                        class="object-contain w-full h-full"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-sm sm:text-base md:text-xl drop-shadow-sm\'></i>'"
                    />
            </div>
            <!-- text -->
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
                <a href="{{ route('dashboard') }}" class="nav-link nav-link-active flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#1a237e] bg-blue-50 hover:bg-blue-100 transition-all duration-200 group">
                    <i class="fas fa-th-large w-5 text-center text-sm text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Dashboard</span>
                    <span class="nav-tooltip">Dashboard</span>
                </a>
            </div>
            
            <!-- Users -->
            <div class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-users w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Users</span>
                    <span class="nav-tooltip">Users</span>
                </a>
            </div>
            
            <!-- Jobs -->
            <div class="nav-item">
                <a href="{{ route('jobs.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-briefcase w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Jobs</span>
                    <span class="nav-tooltip">Jobs</span>
                </a>
            </div>
            
            <!-- Applications -->
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-file-alt w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Applications</span>
                    <span class="nav-tooltip">Applications</span>
                </a>
            </div>
            
            <!-- Label -->
            <p class="sidebar-nav-label text-[10px] text-gray-400 uppercase tracking-wider font-semibold px-3 mt-6 mb-3">Management</p>
            
            <!-- Companies -->
            <div class="nav-item">
                <a href="{{ route('employers.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-building w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Employers</span>
                    <span class="nav-tooltip">Employers</span>
                </a>
            </div>
            
            
            
            <!-- Categories -->
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-tags w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Categories</span>
                    <span class="nav-tooltip">Categories</span>
                </a>
            </div>
            
            <!-- Label -->
            <p class="sidebar-nav-label text-[10px] text-gray-400 uppercase tracking-wider font-semibold px-3 mt-6 mb-3">Settings</p>
            
            <!-- Settings -->
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-cog w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Settings</span>
                    <span class="nav-tooltip">Settings</span>
                </a>
            </div>
            
            <!-- Profile -->
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-user-circle w-5 text-center text-sm text-gray-400 group-hover:text-[#FF7543]"></i>
                    <span class="nav-link-text text-sm font-medium">Profile</span>
                    <span class="nav-tooltip">Profile</span>
                </a>
            </div>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer border-t border-gray-200 px-3 py-4">
            <div class="nav-item">
                <a href="#" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 group">
                    <i class="fas fa-sign-out-alt w-5 text-center text-sm text-gray-400 group-hover:text-red-500"></i>
                    <span class="sidebar-footer-text text-sm font-medium">Logout</span>
                    <span class="nav-tooltip">Logout</span>
                </a>
            </div>
        </div>
    </div>
</aside>