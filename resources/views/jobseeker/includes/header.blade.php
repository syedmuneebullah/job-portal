<header class="bg-white border-b border-gray-200/60 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between px-6 py-3">
        
        <!-- Left Section -->
        <div class="flex items-center gap-4">
            <!-- Toggle Button -->
            <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 text-gray-600 hover:text-[#1a237e]">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Navigation Menu -->
            <div class="md:flex items-center gap-1 ml-2">
                <!-- Page Title -->
                <h1 class="text-xl font-bold text-[#1a237e] hidden sm:block">
                    @yield('page-title', 'Dashboard')
                </h1>
                
                <!-- Menu Divider -->
                <span class="hidden sm:block text-gray-300 mx-3">|</span>
                
                <!-- Find Jobs -->
                <a href="{{ route('candidate.jobs.listings') }}" 
                   class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 text-sm font-medium">
                    <i class="fas fa-search text-xs text-gray-400"></i>
                    <span>Find Jobs</span>
                </a>
                
                <!-- Find Companies -->
                <a href="{{ route('candidate.employers.index') }}" 
                   class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 text-sm font-medium">
                    <i class="fas fa-building text-xs text-gray-400"></i>
                    <span>Find Companies</span>
                </a>
                
                <!-- Find Recruiters -->
                <a href="#" 
                   class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-gray-600 hover:text-[#1a237e] hover:bg-gray-100 transition-all duration-200 text-sm font-medium">
                    <i class="fas fa-user-tie text-xs text-gray-400"></i>
                    <span>Find Recruiters</span>
                </a>
            </div>
        </div>
        
        <!-- Right Section -->
        <div class="flex items-center gap-3">
            
            <!-- Search -->
            <div class="hidden md:flex items-center bg-gray-50 rounded-lg px-3 py-2 border border-gray-200/60">
                <i class="fas fa-search text-gray-400 text-sm"></i>
                <input type="text" placeholder="Search..." 
                        class="bg-transparent border-none outline-none text-sm px-2 w-48 focus:w-64 transition-all duration-300">
            </div>
            
            <!-- Notification Bell -->
            <div class="relative" id="notificationContainer">
                <button id="notificationBtn" 
                        class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 text-gray-600 hover:text-[#1a237e] relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span id="notificationBadge" 
                          class="absolute -top-0.5 -right-0.5 min-w-[20px] h-5 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold badge-pulse"
                          style="display:none;">
                        0
                    </span>
                </button>
                
                <!-- Notification Dropdown -->
                <div id="notificationDropdown" 
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden dropdown-enter z-50"
                     style="display:none;">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">Notifications</h3>
                            <button id="markAllReadBtn" 
                                    class="text-xs text-[#FF7543] hover:underline">
                                Mark all read
                            </button>
                        </div>
                    </div>
                    <div id="notificationList" class="max-h-80 overflow-y-auto">
                        <!-- Default content shown immediately -->
                        <div class="px-4 py-8 text-center text-gray-500" id="notificationLoading">
                            <i class="fas fa-spinner fa-spin text-2xl text-gray-300 mb-2 block"></i>
                            <p class="text-sm">Loading notifications...</p>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-100 text-center">
                        <a href="{{ route('candidate.notifications.index') }}" 
                           class="text-sm text-[#1a237e] font-medium hover:underline">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Profile Dropdown -->
            <div class="relative" id="profileContainer">
                <button id="profileBtn" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#1a237e] to-[#0d1445] flex items-center justify-center text-white text-sm font-semibold">
                        {{ substr(auth()->user()->first_name ?? 'A', 0, 1) }}
                    </div>
                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ auth()->user()->first_name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block"></i>
                </button>
                
                <!-- Profile Dropdown Menu -->
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden dropdown-enter z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->first_name ?? 'Admin' }} {{ auth()->user()->last_name ?? '' }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@jobgenie.com' }}</p>
                    </div>
                    <div class="py-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <i class="fas fa-user-circle text-gray-400 w-5"></i>
                            Edit Profile
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <i class="fas fa-key text-gray-400 w-5"></i>
                            Change Password
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <i class="fas fa-cog text-gray-400 w-5"></i>
                            Settings
                        </a>
                        <hr class="my-1">
                        <a href="{{ route('auth.user.logout') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors text-sm text-red-600">
                            <i class="fas fa-sign-out-alt text-red-400 w-5"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</header>