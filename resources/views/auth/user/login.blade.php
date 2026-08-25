@extends('user.layouts.app')
@section('content')

<main class="min-h-screen bg-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full mx-auto">
        
        <!-- ===== LOGIN CARD ===== -->
        <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/60 border border-gray-100 overflow-hidden grid grid-cols-1 lg:grid-cols-2">
            
            <!-- ===== LEFT PANEL (Branding) ===== -->
            <div class="relative bg-gradient-to-br from-[#1a237e] to-[#0d1445] p-10 lg:p-14 flex flex-col justify-between overflow-hidden">
                
                <!-- Decorative Background Elements -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#FF7543]/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-[#018FFC]/20 rounded-full blur-3xl"></div>
                <div class="absolute top-1/3 left-1/2 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#FF7543] to-[#FF8F65] flex items-center justify-center shadow-lg shadow-[#FF7543]/30">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">
                            SwiftAI <span class="text-[#FF7543]">Recruit</span>
                        </span>
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-6">
                        Welcome Back to<br>
                        Your Career Journey
                    </h2>
                    
                    <p class="text-blue-200 text-sm lg:text-base leading-relaxed mb-8 max-w-md">
                        Log in to access your dashboard, track applications, and continue connecting with top organizations.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                                <i class="fas fa-check text-[#FF7543] text-sm"></i>
                            </div>
                            <span class="text-sm text-blue-100">AI-Powered Job Matching</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                                <i class="fas fa-check text-[#FF7543] text-sm"></i>
                            </div>
                            <span class="text-sm text-blue-100">Track Your Applications</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                                <i class="fas fa-check text-[#FF7543] text-sm"></i>
                            </div>
                            <span class="text-sm text-blue-100">Interview AI Practice</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="relative z-10 mt-12 bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <div class="flex gap-1 mb-3">
                        <i class="fas fa-star text-[#FF7543] text-sm"></i>
                        <i class="fas fa-star text-[#FF7543] text-sm"></i>
                        <i class="fas fa-star text-[#FF7543] text-sm"></i>
                        <i class="fas fa-star text-[#FF7543] text-sm"></i>
                        <i class="fas fa-star text-[#FF7543] text-sm"></i>
                    </div>
                    <p class="text-blue-100 text-sm italic mb-4">
                        "SwiftAI Recruit transformed my job search. The AI matching is incredibly accurate!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#FF7543] flex items-center justify-center text-white font-bold text-sm">
                            AN
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Ahmad N.</p>
                            <p class="text-blue-300 text-xs">Software Engineer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== RIGHT PANEL (Login Form) ===== -->
            <div class="p-10 lg:p-14 flex flex-col justify-center bg-white">
                
                <div class="max-w-md mx-auto w-full">
                    <!-- Heading -->
                    <h3 class="text-2xl lg:text-3xl font-bold text-[#1a237e] mb-2">Sign In</h3>
                    <p class="text-gray-500 text-sm mb-8">
                        Don't have an account? <a href="#" class="text-[#FF7543] font-semibold hover:underline">Create one</a>
                    </p>

                    <!-- Social Login -->
                    <div class="mb-6">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Or continue with</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button class="flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-600">Google</span>
                            </button>
                            <button class="flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-600">Facebook</span>
                            </button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-xs font-semibold text-gray-400">OR</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Form -->
                    <form action="" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#1a237e] mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required 
                                    placeholder="john@example.com"
                                    class="w-full pl-10 pr-4 py-3.5 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400"
                                >
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="text-sm font-semibold text-[#1a237e]">Password</label>
                                <a href="#" class="text-xs font-semibold text-[#FF7543] hover:underline">Forgot Password?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required 
                                    placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-3.5 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400"
                                >
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="sr-only peer">
                                <div class="w-5 h-5 rounded-md border-2 border-gray-300 peer-checked:border-[#1a237e] peer-checked:bg-[#1a237e] flex items-center justify-center transition-all">
                                    <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-4 bg-[#1a237e] hover:bg-[#0d1445] text-white font-bold rounded-xl transition-all duration-300 shadow-xl shadow-[#1a237e]/20 hover:shadow-2xl hover:shadow-[#1a237e]/30 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection