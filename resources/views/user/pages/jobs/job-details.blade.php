<!-- ============================================================ -->
<!-- JOB DETAILS PAGE · Balanced Malaysian Theme                  -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        
        <!-- ===== BREADCRUMB ===== -->
        <nav class="flex items-center gap-2 text-sm mb-6" aria-label="Breadcrumb">
            <a href="#" class="text-slate-500 hover:text-[#1A237E] transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="#" class="text-slate-500 hover:text-[#1A237E] transition-colors">Jobs</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-[#ff7543] font-semibold">Senior Frontend Developer</span>
        </nav>

        <!-- ===== MAIN CONTENT GRID ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- ===== LEFT COLUMN - Job Details ===== -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Job Header Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-2xl font-bold shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                    <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Senior Frontend Developer</h1>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="text-sm text-gray-600">TechCorp MY</span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                        Kuala Lumpur, Malaysia
                                    </span>
                                    <span class="hidden sm:inline w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[#ff7543] text-xs"></i>
                                        Posted 2 days ago
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active
                            </span>
                            <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                Urgent Hiring
                            </span>
                        </div>
                    </div>
                    
                    <!-- Job Meta Tags -->
                    <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                        <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full">Full-time</span>
                        <span class="text-xs font-medium bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full">Remote</span>
                        <span class="text-xs font-medium bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full">RM 8,000 - RM 12,000</span>
                        <span class="text-xs font-medium bg-orange-50 text-orange-700 px-3 py-1.5 rounded-full">Senior Level</span>
                        <span class="text-xs font-medium bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full">5+ Years Experience</span>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 mt-5 pt-5 border-t border-gray-100">
                        <button class="flex-1 md:flex-none px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Apply Now
                        </button>
                        <button class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50">
                            <i class="far fa-bookmark"></i>
                            Save Job
                        </button>
                        <button class="px-5 py-3 border-2 border-gray-200 hover:border-[#1A237E] text-gray-600 hover:text-[#1A237E] font-semibold rounded-xl transition-all duration-300 flex items-center gap-2 hover:bg-gray-50">
                            <i class="fas fa-share-alt"></i>
                            Share
                        </button>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-file-alt text-[#1A237E]"></i>
                        Job Description
                    </h2>
                    <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                        <p>We are looking for a talented Senior Frontend Developer to join our growing team in Kuala Lumpur. You will be responsible for building and maintaining high-quality web applications that serve millions of users across Malaysia and Southeast Asia.</p>
                        
                        <h4 class="font-semibold text-gray-800 mt-4">Key Responsibilities:</h4>
                        <ul class="list-disc pl-5 space-y-1.5 text-sm">
                            <li>Develop and maintain responsive web applications using React.js and Next.js</li>
                            <li>Collaborate with UX/UI designers to implement pixel-perfect designs</li>
                            <li>Write clean, maintainable, and testable code following best practices</li>
                            <li>Optimize applications for maximum speed and scalability</li>
                            <li>Mentor junior developers and conduct code reviews</li>
                            <li>Work closely with backend developers to integrate APIs</li>
                        </ul>
                        
                        <h4 class="font-semibold text-gray-800 mt-4">Requirements:</h4>
                        <ul class="list-disc pl-5 space-y-1.5 text-sm">
                            <li>5+ years of experience in frontend development</li>
                            <li>Expertise in React.js, TypeScript, and modern JavaScript (ES6+)</li>
                            <li>Experience with state management (Redux, Zustand, or Context API)</li>
                            <li>Strong understanding of CSS frameworks (Tailwind CSS preferred)</li>
                            <li>Experience with RESTful APIs and GraphQL</li>
                            <li>Bachelor's degree in Computer Science or related field</li>
                            <li>Excellent problem-solving and communication skills</li>
                        </ul>
                        
                        <h4 class="font-semibold text-gray-800 mt-4">Benefits:</h4>
                        <ul class="list-disc pl-5 space-y-1.5 text-sm">
                            <li>Competitive salary package (RM 8,000 - RM 12,000)</li>
                            <li>Flexible working hours and remote work options</li>
                            <li>Health insurance and medical benefits</li>
                            <li>Professional development budget (RM 5,000/year)</li>
                            <li>Annual performance bonus</li>
                            <li>Team building activities and company retreats</li>
                        </ul>
                    </div>
                </div>

                <!-- Company Overview -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-[#1A237E]"></i>
                        About the Company
                    </h2>
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <div class="w-20 h-20 rounded-2xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-3xl font-bold shrink-0">
                            T
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">TechCorp MY</h3>
                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">
                                <i class="fas fa-map-marker-alt text-[#ff7543] text-xs"></i>
                                Kuala Lumpur, Malaysia
                            </p>
                            <p class="text-sm text-gray-600 mt-2 max-w-2xl">
                                TechCorp MY is a leading technology company in Malaysia, specializing in innovative software solutions for enterprises across Southeast Asia. We pride ourselves on our collaborative culture and commitment to excellence.
                            </p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">50-100 Employees</span>
                                <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Founded 2018</span>
                                <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Technology</span>
                            </div>
                            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors mt-3">
                                View Company Profile
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Similar Jobs -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-briefcase text-[#1A237E]"></i>
                        Similar Jobs You Might Like
                    </h2>
                    <div class="space-y-3">
                        <!-- Similar Job 1 -->
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-[#1A237E]/20 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                        <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors">React Developer</h4>
                                    <p class="text-xs text-gray-500">TechCorp MY · Remote</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-2 sm:mt-0">
                                <span class="text-xs font-medium text-gray-500">RM 7k-10k</span>
                                <a href="#" class="text-xs font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors">View</a>
                            </div>
                        </div>
                        
                        <!-- Similar Job 2 -->
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-[#1A237E]/20 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                        <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors">UI/UX Designer</h4>
                                    <p class="text-xs text-gray-500">DesignStudio · Penang</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-2 sm:mt-0">
                                <span class="text-xs font-medium text-gray-500">RM 5k-8k</span>
                                <a href="#" class="text-xs font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors">View</a>
                            </div>
                        </div>
                        
                        <!-- Similar Job 3 -->
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-[#1A237E]/20 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 20a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v2H2v-2Z"></path>
                                        <path d="M10 4a4 4 0 0 0-4 4v6h2V8a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v6h2V8a4 4 0 0 0-4-4h-4Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#1A237E] transition-colors">DevOps Engineer</h4>
                                    <p class="text-xs text-gray-500">CloudSystems · Selangor</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-2 sm:mt-0">
                                <span class="text-xs font-medium text-gray-500">RM 9k-14k</span>
                                <a href="#" class="text-xs font-semibold text-[#1A237E] hover:text-[#0D1445] transition-colors">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== RIGHT COLUMN - Sidebar ===== -->
            <div class="space-y-6">
                
                <!-- Quick Apply Card -->
                <div class="bg-gradient-to-br from-[#1A237E]/5 to-[#1A237E]/10 rounded-2xl border-2 border-[#1A237E]/20 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-3">Quick Apply</h3>
                    <p class="text-sm text-gray-600 mb-4">Apply with your profile in one click.</p>
                    <button class="w-full py-3 bg-[#1A237E] hover:bg-[#0D1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1A237E]/20 hover:shadow-xl hover:shadow-[#1A237E]/30 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Apply Now
                    </button>
                    <div class="mt-3 text-center">
                        <a href="#" class="text-xs text-[#1A237E] hover:text-[#0D1445] font-medium transition-colors">
                            <i class="far fa-file-alt mr-1"></i>
                            Upload new resume
                        </a>
                    </div>
                </div>

                <!-- Job Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-[#1A237E]"></i>
                        Job Summary
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-briefcase text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Job Type</p>
                                <p class="text-sm font-medium text-gray-700">Full-time</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-[#ff7543] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Location</p>
                                <p class="text-sm font-medium text-gray-700">Kuala Lumpur, Malaysia</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-money-bill-wave text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Salary</p>
                                <p class="text-sm font-medium text-gray-700">RM 8,000 - RM 12,000</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-alt text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Posted</p>
                                <p class="text-sm font-medium text-gray-700">2 days ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-users text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Applicants</p>
                                <p class="text-sm font-medium text-gray-700">45 applied</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-[#1A237E] text-sm mt-0.5 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-400">Experience</p>
                                <p class="text-sm font-medium text-gray-700">5+ Years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Required -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-code text-[#1A237E]"></i>
                        Skills Required
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">React.js</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">TypeScript</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">Next.js</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">Tailwind CSS</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">Redux</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">GraphQL</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">Git</span>
                        <span class="text-xs font-medium bg-blue-50 text-[#1A237E] px-3 py-1.5 rounded-full border border-blue-100">Jest</span>
                    </div>
                </div>

                <!-- Share Job -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-share-alt text-[#1A237E]"></i>
                        Share This Job
                    </h3>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="flex-1 p-2.5 rounded-xl border border-gray-200 hover:border-[#1A237E] hover:bg-gray-50 transition-all duration-300 text-center text-gray-600 hover:text-[#1A237E]">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>

                <!-- Report Job -->
                <a href="#" class="flex items-center justify-center gap-2 text-sm text-slate-400 hover:text-[#1A237E] transition-colors p-3">
                    <i class="fas fa-flag"></i>
                    <span>Report this job</span>
                </a>
            </div>
        </div>
    </div>
</main>

@endsection