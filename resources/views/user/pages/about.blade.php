<!-- ============================================================ -->
<!-- ABOUT US PAGE · Balanced Malaysian Theme                      -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="text-center mb-10 md:mb-14">
            <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                About Us
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#1A237E] mb-3">
                Empowering Careers Across <span class="text-[#D32F2F]">Malaysia</span>
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                We're on a mission to connect talented professionals with their dream jobs and help companies build amazing teams.
            </p>
        </div>

        <!-- ===== OUR MISSION ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center mb-12 md:mb-16">
            <div class="order-2 lg:order-1">
                <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    Our Mission
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1A237E] mb-4">
                    Bridging Talent with <span class="text-[#D32F2F]">Opportunity</span>
                </h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    At JobHunt, we believe that everyone deserves to find meaningful work that aligns with their skills, passions, and lifestyle. We're dedicated to transforming the recruitment landscape in Malaysia by making job searching smarter, faster, and more human.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Whether you're a fresh graduate looking for your first role, an experienced professional seeking new challenges, or a company searching for top talent, we're here to help you succeed.
                </p>
                <div class="flex flex-wrap gap-4 mt-6">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-600">AI-Powered Matching</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-600">Trusted by 500+ Companies</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-600">10,000+ Active Candidates</span>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="bg-gradient-to-br from-[#1A237E]/5 to-[#D32F2F]/10 rounded-3xl p-8 text-center border border-[#1A237E]/10">
                    <div class="w-24 h-24 rounded-full bg-[#1A237E]/10 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullseye text-4xl text-[#1A237E]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#1A237E] mb-2">Our Vision</h3>
                    <p class="text-gray-600 text-sm leading-relaxed max-w-sm mx-auto">
                        To become Malaysia's most trusted career platform, empowering every professional to unlock their full potential.
                    </p>
                </div>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12 md:mb-16">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-md transition-all duration-300">
                <div class="text-3xl md:text-4xl font-bold text-[#1A237E]">10K+</div>
                <p class="text-sm text-gray-500 mt-1">Active Jobs</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-md transition-all duration-300">
                <div class="text-3xl md:text-4xl font-bold text-[#1A237E]">500+</div>
                <p class="text-sm text-gray-500 mt-1">Companies</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-md transition-all duration-300">
                <div class="text-3xl md:text-4xl font-bold text-[#1A237E]">50K+</div>
                <p class="text-sm text-gray-500 mt-1">Candidates</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-md transition-all duration-300">
                <div class="text-3xl md:text-4xl font-bold text-[#1A237E]">98%</div>
                <p class="text-sm text-gray-500 mt-1">Satisfaction Rate</p>
            </div>
        </div>

        <!-- ===== OUR VALUES ===== -->
        <div class="mb-12 md:mb-16">
            <div class="text-center mb-8">
                <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    What We Stand For
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    Our Core <span class="text-[#D32F2F]">Values</span>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <!-- Value 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-full bg-gray-100/70 flex items-center justify-center mx-auto mb-4 text-[#1A237E] group-hover:bg-[#1A237E] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Trust & Integrity</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        We build honest relationships with job seekers and employers, ensuring transparency in every interaction.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-full bg-gray-100/70 flex items-center justify-center mx-auto mb-4 text-[#1A237E] group-hover:bg-[#1A237E] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-lightbulb text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Innovation</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        We leverage cutting-edge technology to create smarter, faster, and more efficient recruitment solutions.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-full bg-gray-100/70 flex items-center justify-center mx-auto mb-4 text-[#1A237E] group-hover:bg-[#1A237E] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Community First</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        We're passionate about building a thriving community where professionals and companies can connect and grow together.
                    </p>
                </div>
            </div>
        </div>

        <!-- ===== OUR TEAM ===== -->
        <div class="mb-12 md:mb-16">
            <div class="text-center mb-8">
                <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    Meet The Team
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    The People Behind <span class="text-[#D32F2F]">JobHunt</span>
                </h2>
                <p class="text-gray-500 text-sm mt-2 max-w-2xl mx-auto">
                    A passionate team dedicated to transforming the recruitment landscape in Malaysia.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#1A237E]/20 to-[#D32F2F]/20 flex items-center justify-center mx-auto mb-3 text-2xl font-bold text-[#1A237E]">
                        <i class="fas fa-user-circle text-5xl text-[#1A237E]/40"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-800">Ahmad Faiz</h4>
                    <p class="text-xs text-gray-500">CEO & Co-Founder</p>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#1A237E]/20 to-[#D32F2F]/20 flex items-center justify-center mx-auto mb-3 text-2xl font-bold text-[#1A237E]">
                        <i class="fas fa-user-circle text-5xl text-[#1A237E]/40"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-800">Siti Nurhaliza</h4>
                    <p class="text-xs text-gray-500">CTO & Co-Founder</p>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#1A237E]/20 to-[#D32F2F]/20 flex items-center justify-center mx-auto mb-3 text-2xl font-bold text-[#1A237E]">
                        <i class="fas fa-user-circle text-5xl text-[#1A237E]/40"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-800">Ravi Krishnan</h4>
                    <p class="text-xs text-gray-500">Head of Product</p>
                </div>

                <!-- Team Member 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#1A237E]/20 to-[#D32F2F]/20 flex items-center justify-center mx-auto mb-3 text-2xl font-bold text-[#1A237E]">
                        <i class="fas fa-user-circle text-5xl text-[#1A237E]/40"></i>
                    </div>
                    <h4 class="text-sm font-bold text-gray-800">Wong Mei Ling</h4>
                    <p class="text-xs text-gray-500">Head of Marketing</p>
                </div>
            </div>
        </div>

        <!-- ===== WHY CHOOSE US ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8 mb-12">
            <div class="text-center mb-8">
                <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-3 py-1 rounded-full uppercase tracking-wider mb-3">
                    Why Choose Us
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    What Makes Us <span class="text-[#D32F2F]">Different</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Feature 1 -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                        <i class="fas fa-brain text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-1">AI-Powered Matching</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Our smart algorithm connects you with the most relevant opportunities based on your skills and preferences.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                        <i class="fas fa-shield-alt text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-1">Verified Employers</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">All companies on our platform are verified to ensure a safe and trustworthy job search experience.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-1">Fast Application Process</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Apply to jobs in seconds with our streamlined one-click application system.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-1">Dedicated Support</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Our friendly support team is always here to help you with any questions or concerns.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== CTA SECTION ===== -->
        <div class="bg-gradient-to-br from-[#1A237E] to-[#0D1445] rounded-2xl p-8 md:p-12 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                Ready to Find Your Dream Job?
            </h2>
            <p class="text-blue-200/80 max-w-2xl mx-auto text-sm md:text-base mb-6">
                Join thousands of professionals already using JobHunt to advance their careers.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#" class="px-8 py-3 bg-white hover:bg-gray-100 text-[#1A237E] font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <i class="fas fa-search mr-2"></i>
                    Browse Jobs
                </a>
                <a href="#" class="px-8 py-3 bg-[#D32F2F] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-red-500/20 hover:shadow-xl hover:shadow-red-500/30 hover:-translate-y-0.5">
                    <i class="fas fa-user-plus mr-2"></i>
                    Get Started
                </a>
            </div>
        </div>
    </div>
</main>

@endsection