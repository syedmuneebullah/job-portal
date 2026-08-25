<!-- ============================================================ -->
<!-- SWIFTAI RECRUIT · Landing Page                                -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main>

    <!-- ============================================================ -->
    <!-- HERO SECTION (No Background Image, Centered Content)         -->
    <!-- ============================================================ -->
    <section class="relative w-full overflow-hidden bg-white py-16 md:py-24" id="home">
        
        <!-- Subtle Background Gradients -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#018FFC]/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#FF7543]/5 rounded-full blur-3xl"></div>
        </div>

        <!-- ===== CONTENT ===== -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
                
                <!-- Hero Content -->
                <div class="text-center lg:text-left hero-fade">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-[#018FFC]/5 backdrop-blur-sm border border-[#018FFC]/20 text-[#018FFC] text-xs font-semibold tracking-wide px-4 py-1.5 rounded-full mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="motion-safe:animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF7543] opacity-60"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FF7543]"></span>
                        </span>
                        AI-Powered Recruitment Solutions
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[#1a237e] leading-[1.08] tracking-tight mb-6">
                        Transform Your
                        <span class="text-[#FF7543] font-extrabold">Recruitment</span>
                        with Intelligence
                    </h1>
                    
                    <p class="text-lg text-[#4B5563] leading-relaxed max-w-xl mx-auto lg:mx-0 mb-10">
                        Leverage cutting-edge AI technology to connect talent with opportunity swiftly and seamlessly. 
                        Empowering job seekers, employers, and educational institutions.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#" class="px-8 py-4 bg-gradient-to-r from-[#018FFC] to-[#0A7BD9] hover:from-[#0A7BD9] hover:to-[#018FFC] text-white font-semibold rounded-xl transition-all duration-300 shadow-xl shadow-[#018FFC]/20 hover:shadow-2xl hover:shadow-[#018FFC]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-rocket"></i>
                            Get Started
                        </a>
                        <a href="#" class="px-8 py-4 bg-[#FF7543] hover:bg-[#E65C00] text-white font-semibold rounded-xl transition-all duration-300 shadow-xl shadow-[#FF7543]/20 hover:shadow-2xl hover:shadow-[#FF7543]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-play-circle"></i>
                            Watch Demo
                        </a>
                    </div>
                    
                    
                </div>
                
                <!-- Hero Visual -->
                <div class="hidden lg:flex items-center justify-center hero-fade">
                    <div class="relative">
                        <!-- Animated Glow -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#018FFC]/15 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-[#FF7543]/10 rounded-full blur-3xl animate-pulse delay-700"></div>
                        
                        <div class="relative bg-white border border-gray-200 rounded-3xl p-8 w-80 shadow-2xl shadow-gray-200/50">
                            <!-- AI Icon -->
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-[#018FFC] to-[#FF7543] flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-[#018FFC]/20">
                                <i class="fas fa-brain text-white text-5xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-[#1a237e] text-center mb-2">SwiftAI Recruit</h3>
                            <p class="text-[#4B5563] text-sm text-center">AI-Driven Recruitment Solutions</p>
                            
                            <!-- Decorative Dots -->
                            <div class="flex justify-center gap-2 mt-4">
                                <span class="w-2 h-2 rounded-full bg-[#018FFC]"></span>
                                <span class="w-2 h-2 rounded-full bg-[#FF7543]"></span>
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span class="w-2 h-2 rounded-full bg-[#018FFC]"></span>
                                <span class="w-2 h-2 rounded-full bg-[#FF7543]"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </section>

    <!-- ===== STYLES ===== -->
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
        
        .delay-700 {
            animation-delay: 700ms;
        }
    </style>
    <!-- ============================================================ -->
    <!-- SERVICES SECTION                                              -->
    <!-- ============================================================ -->
    <section class="relative py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-16">
                <span class="inline-block text-xs font-semibold text-[#FF6B35] bg-[#FF6B35]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                    Our Services
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-[#1a237e] mb-3">
                    Comprehensive <span class="text-[#FF6B35]">Recruitment</span> Solutions
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                    Tailored services designed to meet the needs of job seekers, employers, and educational institutions.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Service 1 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-brain text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">AI-Driven Recruitment</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Leverage cutting-edge AI technology to streamline hiring and match candidates with ideal positions swiftly and accurately.
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">Job Applicant Recruitment</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Connect employers with qualified job applicants efficiently, saving time and resources while ensuring a seamless hiring experience.
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">Student Recruitment</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Assist educational institutions in attracting and enrolling top-notch students using AI tools to identify and target prospective candidates.
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-bolt text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">Fast-Track Recruitment</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Prioritize efficiency without compromising quality, enabling organizations to fill vacant positions quickly and effectively.
                    </p>
                </div>

                <!-- Service 5 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-tools text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">AI Tool Development</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Develop custom AI tools tailored to enhance recruitment processes, including resume screening, candidate matching, and predictive analytics.
                    </p>
                </div>

                <!-- Service 6 -->
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100/80 p-6 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35] mb-4 group-hover:bg-[#FF6B35] group-hover:text-white transition-all duration-300">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#1a237e] mb-2">Consulting & Training</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Expert consulting and training programs to optimize recruitment strategies, leverage AI technologies, and stay ahead of industry trends.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- ABOUT SECTION                                                -->
    <!-- ============================================================ -->
    <section class="relative py-16 md:py-20 bg-gradient-to-b from-slate-50/50 via-white to-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div>
                    <span class="inline-block text-xs font-semibold text-[#FF6B35] bg-[#FF6B35]/10 px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                        About SwiftAI Recruit
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-[#1a237e] mb-4">
                        Where Innovation Meets <span class="text-[#FF6B35]">Efficiency</span>
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Welcome to SwiftAI Recruit, where innovation meets efficiency in the realm of recruitment. As a cutting-edge company at the forefront of AI-driven solutions, we specialize in revolutionizing the recruitment process for both job seekers and educational institutions.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        With our streamlined approach and advanced technologies, we're dedicated to connecting talent with opportunity swiftly and seamlessly.
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
                            <span class="text-sm text-gray-600">Verified Employers</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">Fast-Track Hiring</span>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Mission & Vision -->
                <div class="space-y-6">
                    <!-- Mission -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35]">
                                <i class="fas fa-bullseye text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#1a237e]">Our Mission</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            To redefine the recruitment experience by leveraging the power of artificial intelligence. We aim to provide unparalleled speed and precision in matching qualified candidates with their ideal positions.
                        </p>
                    </div>
                    
                    <!-- Vision -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FF6B35]/10 flex items-center justify-center text-[#FF6B35]">
                                <i class="fas fa-eye text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-[#1a237e]">Our Vision</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            To be the leading provider of AI-driven recruitment solutions globally. We envision a future where recruitment is faster, more accurate, inclusive, and accessible to all.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- STATS SECTION                                                 -->
    <!-- ============================================================ -->
    <section class="relative py-12 bg-[#1a237e]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-[#FF6B35]">10K+</div>
                    <p class="text-white/60 text-sm mt-1">Active Jobs</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-[#FF6B35]">500+</div>
                    <p class="text-white/60 text-sm mt-1">Companies</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-[#FF6B35]">50K+</div>
                    <p class="text-white/60 text-sm mt-1">Candidates</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-[#FF6B35]">98%</div>
                    <p class="text-white/60 text-sm mt-1">Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- CTA SECTION                                                  -->
    <!-- ============================================================ -->
    <section class="relative py-16 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#1a237e] mb-4">
                Ready to Transform Your <span class="text-[#FF6B35]">Recruitment</span>?
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base mb-8">
                Join thousands of professionals and companies already using SwiftAI Recruit to find and hire top talent.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="px-8 py-3.5 bg-gradient-to-r from-[#FF6B35] to-[#FF8F65] hover:from-[#E55A2B] hover:to-[#FF6B35] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#FF6B35]/30 hover:shadow-xl hover:shadow-[#FF6B35]/40 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-rocket"></i>
                    Get Started
                </a>
                <a href="#" class="px-8 py-3.5 border-2 border-[#1a237e] hover:bg-[#1a237e] hover:text-white text-[#1a237e] font-semibold rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-phone"></i>
                    Contact Sales
                </a>
            </div>
        </div>
    </section>

</main>

<!-- ===== STYLES ===== -->
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
    
    .delay-700 {
        animation-delay: 700ms;
    }
    .delay-1000 {
        animation-delay: 1000ms;
    }
</style>

@endsection