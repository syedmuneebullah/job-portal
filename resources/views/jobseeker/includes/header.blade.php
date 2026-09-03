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
            <div class="relative">
                <button id="notificationBtn" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 text-gray-600 hover:text-[#1a237e] relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold badge-pulse">
                        5
                    </span>
                </button>
                
                <!-- Notification Dropdown -->
                <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden dropdown-enter">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">Notifications</h3>
                            <button class="text-xs text-[#FF7543] hover:underline">Mark all read</button>
                        </div>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">New user registered</p>
                                <p class="text-xs text-gray-500">John Doe created an account</p>
                                <p class="text-[10px] text-gray-400 mt-1">5 min ago</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Application approved</p>
                                <p class="text-xs text-gray-500">Developer position approved</p>
                                <p class="text-[10px] text-gray-400 mt-1">1 hour ago</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Payment failed</p>
                                <p class="text-xs text-gray-500">Invoice #1234 payment failed</p>
                                <p class="text-[10px] text-gray-400 mt-1">2 hours ago</p>
                            </div>
                        </a>
                    </div>
                    <div class="p-3 border-t border-gray-100 text-center">
                        <a href="#" class="text-sm text-[#1a237e] font-medium hover:underline">View all notifications</a>
                    </div>
                </div>
            </div>
            
            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#1a237e] to-[#0d1445] flex items-center justify-center text-white text-sm font-semibold">
                        A
                    </div>
                    <span class="hidden md:block text-sm font-medium text-gray-700">Admin</span>
                    <i class="fas fa-chevron-down text-xs text-gray-400 hidden md:block"></i>
                </button>
                
                <!-- Profile Dropdown Menu -->
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden dropdown-enter">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">Admin User</p>
                        <p class="text-xs text-gray-500">admin@jobgenie.com</p>
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