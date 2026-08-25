<!-- ============================================================ -->
<!-- CONTACT US PAGE · Balanced Malaysian Theme                   -->
<!-- ============================================================ -->
@extends('user.layouts.app')
@section('content')

<main class="bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="text-center mb-10 md:mb-14">
            <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                Get in Touch
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#1A237E] mb-3">
                Contact <span class="text-[#D32F2F]">Us</span>
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <!-- ===== CONTACT GRID ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- ===== LEFT COLUMN - Contact Info ===== -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Contact Cards -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <div class="space-y-5">
                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                                <i class="fas fa-phone text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Phone</p>
                                <p class="text-sm font-semibold text-gray-800">+60 12-345 6789</p>
                                <p class="text-xs text-gray-400">Mon-Fri 9AM - 6PM</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                                <i class="fas fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Email</p>
                                <p class="text-sm font-semibold text-gray-800">info@jobhunt.my</p>
                                <p class="text-xs text-gray-400">We'll respond within 24hrs</p>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Location</p>
                                <p class="text-sm font-semibold text-gray-800">Kuala Lumpur, Malaysia</p>
                                <p class="text-xs text-gray-400">Menara JobHunt, KLCC</p>
                            </div>
                        </div>
                        
                        <!-- Working Hours -->
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-gray-100/70 flex items-center justify-center text-[#1A237E] shrink-0">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Working Hours</p>
                                <p class="text-sm font-semibold text-gray-800">Monday - Friday</p>
                                <p class="text-xs text-gray-400">9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl bg-gray-100/70 hover:bg-[#1A237E] hover:text-white transition-all duration-300 flex items-center justify-center text-[#1A237E]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-gray-100/70 hover:bg-[#1A237E] hover:text-white transition-all duration-300 flex items-center justify-center text-[#1A237E]">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-gray-100/70 hover:bg-[#1A237E] hover:text-white transition-all duration-300 flex items-center justify-center text-[#1A237E]">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-gray-100/70 hover:bg-[#1A237E] hover:text-white transition-all duration-300 flex items-center justify-center text-[#1A237E]">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-gray-100/70 hover:bg-[#1A237E] hover:text-white transition-all duration-300 flex items-center justify-center text-[#1A237E]">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Map Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 overflow-hidden">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">Find Us</h3>
                    <div class="rounded-xl overflow-hidden h-48 bg-gray-100/70 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt text-4xl text-[#1A237E]/30 mb-2"></i>
                            <p class="text-xs">Interactive Map Here</p>
                            <p class="text-[10px] text-gray-400">Menara JobHunt, KLCC</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== RIGHT COLUMN - Contact Form ===== -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-[#1A237E] mb-2">Send Us a Message</h2>
                    <p class="text-sm text-gray-500 mb-6">Fill in the form below and we'll get back to you shortly.</p>
                    
                    <form action="#" method="POST" class="space-y-5">
                        <!-- Name & Email Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="John Doe" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1A237E] focus:ring-2 focus:ring-[#1A237E]/20 outline-none transition-all text-sm">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" placeholder="john@example.com" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1A237E] focus:ring-2 focus:ring-[#1A237E]/20 outline-none transition-all text-sm">
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" placeholder="How can we help?" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1A237E] focus:ring-2 focus:ring-[#1A237E]/20 outline-none transition-all text-sm">
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" 
                                      placeholder="Write your message here..." 
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#1A237E] focus:ring-2 focus:ring-[#1A237E]/20 outline-none transition-all text-sm resize-none"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full md:w-auto px-8 py-3.5 bg-[#1A237E] hover:bg-[#0D1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1A237E]/20 hover:shadow-xl hover:shadow-[#1A237E]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== FAQ SECTION ===== -->
        <div class="mt-12 md:mt-16">
            <div class="text-center mb-8">
                <span class="inline-block text-xs font-semibold text-[#D32F2F] bg-[#D32F2F]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-3">
                    Quick Answers
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1A237E]">
                    Frequently Asked <span class="text-[#D32F2F]">Questions</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#1A237E]/10 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                            Q
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">How do I apply for a job?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Simply browse jobs, click "Apply Now" on any listing, and submit your application with your resume and cover letter.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#1A237E]/10 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                            Q
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">Is JobHunt free to use?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Yes! JobHunt is completely free for job seekers. Employers can post jobs with our affordable plans.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#1A237E]/10 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                            Q
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">How do I create a company profile?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Register as an employer, verify your email, and complete your company profile with logo, description, and location.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5 md:p-6 hover:shadow-md transition-all duration-300">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#1A237E]/10 flex items-center justify-center text-[#1A237E] text-sm font-bold shrink-0">
                            Q
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">What if I forget my password?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Click "Forgot Password" on the login page and we'll send you a link to reset your password securely.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection