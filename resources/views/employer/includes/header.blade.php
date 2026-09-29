<header class="bg-white border-b border-gray-200/60 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between px-6 py-3">
        
        <!-- Left Section -->
        <div class="flex items-center gap-4">
            <!-- Toggle Button -->
            <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 text-gray-600 hover:text-[#1a237e]">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Page Title -->
            <h1 class="text-xl font-bold text-[#1a237e] hidden sm:block">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>
        
        <!-- Right Section -->
        <div class="flex items-center gap-3">
            
            <!-- Search -->
            <div class="hidden md:flex items-center bg-gray-50 rounded-lg px-3 py-2 border border-gray-200/60">
                <i class="fas fa-search text-gray-400 text-sm"></i>
                <input type="text" placeholder="Search..." 
                        class="bg-transparent border-none outline-none text-sm px-2 w-48 focus:w-64 transition-all duration-300">
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
                        <a href="{{ route('employer.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <i class="fas fa-user-circle text-gray-400 w-5"></i>
                            Edit Profile
                        </a>
                        <a href="{{route('employer.profile.change-password')}}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <i class="fas fa-key text-gray-400 w-5"></i>
                            Change Password
                        </a>
                       
                        <hr class="my-1">
                        <a href="{{route('auth.user.logout')}}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors text-sm text-red-600">
                            <i class="fas fa-sign-out-alt text-red-400 w-5"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</header>