<!-- ============================================================ -->
<!-- FOOTER · Matching Hero Theme (Blue & Orange)                 -->
<!-- ============================================================ -->
<footer class="w-full bg-white/90 backdrop-blur-sm border-t border-orange-200/60 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        
        <!-- ===== MAIN FOOTER GRID ===== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
            
            <!-- Column 1: Brand -->
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-2xl">
                        <img 
                        src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75" 
                        alt="SwiftAI Recruit" 
                        class="object-contain"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-base md:text-xl drop-shadow-sm\'></i>'"
                    />
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight">
                        <span class="text-xl md:text-2xl font-bold text-[#1A237E]">Swift<span class="">AI</span> <span class="text-[#1A237E]">Recruit</span></span>
                    </span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed max-w-xs">
                    Find your dream job with AI-powered matching. Join thousands of professionals already using JobHunt.
                </p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-orange-100 transition-colors flex items-center justify-center text-slate-600 hover:text-[#FF7543]">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-orange-100 transition-colors flex items-center justify-center text-slate-600 hover:text-[#FF7543]">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-orange-100 transition-colors flex items-center justify-center text-slate-600 hover:text-[#FF7543]">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-orange-100 transition-colors flex items-center justify-center text-slate-600 hover:text-[#FF7543]">
                        <i class="fab fa-github text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: For Job Seekers -->
            <div>
                <h4 class="text-sm font-semibold text-[#1A1A1A] uppercase tracking-wider mb-4">For Job Seekers</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Browse Jobs</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Resume Builder</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Career Advice</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Salary Calculator</a></li>
                </ul>
            </div>

            <!-- Column 3: For Employers -->
            <div>
                <h4 class="text-sm font-semibold text-[#1A1A1A] uppercase tracking-wider mb-4">For Employers</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Post a Job</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Talent Search</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Employer Branding</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Pricing</a></li>
                </ul>
            </div>

            <!-- Column 4: Support & Legal -->
            <div>
                <h4 class="text-sm font-semibold text-[#1A1A1A] uppercase tracking-wider mb-4">Support</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('user.about') }}" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> About Us</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Privacy Policy</a></li>
                    <li><a href="#" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Terms of Service</a></li>
                    <li><a href="{{ route('user.contact') }}" class="text-sm text-slate-500 hover:text-[#018FFC] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-[#018FFC]"></i> Contact Us</a></li>
                </ul>
            </div>
        </div>

        <!-- ===== DIVIDER ===== -->
        <div class="border-t border-orange-200/60 my-8 md:my-10"></div>

        <!-- ===== BOTTOM BAR ===== -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                &copy; 2026 <span class="font-semibold text-[#FF7543]">JobHunt</span>. All rights reserved.
            </p>
            <div class="flex items-center gap-6 text-sm">
                <a href="#" class="text-slate-500 hover:text-[#FF7543] transition-colors">Privacy</a>
                <a href="#" class="text-slate-500 hover:text-[#FF7543] transition-colors">Terms</a>
                <a href="#" class="text-slate-500 hover:text-[#FF7543] transition-colors">Cookies</a>
                <span class="flex items-center gap-2 text-slate-400">
                    <i class="fas fa-globe text-xs"></i>
                    <select class="bg-transparent border-none text-sm text-slate-600 focus:outline-none cursor-pointer hover:text-[#FF7543]">
                        <option>English</option>
                        <option>Bahasa Malaysia</option>
                        <option>Chinese</option>
                        <option>Tamil</option>
                    </select>
                </span>
            </div>
        </div>

        <!-- ===== BACK TO TOP (floating) ===== -->
        <button id="backToTop" class="fixed bottom-6 right-6 w-11 h-11 rounded-full bg-gradient-to-r from-[#018FFC] to-[#FF7543] text-white shadow-lg shadow-orange-200/40 hover:from-[#FF7543] hover:to-[#018FFC] transition-all flex items-center justify-center opacity-0 pointer-events-none">
            <i class="fas fa-arrow-up text-sm"></i>
        </button>
    </div>
</footer>