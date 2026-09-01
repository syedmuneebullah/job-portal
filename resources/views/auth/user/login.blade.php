
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5">
    <title>JobPortal · header</title>
    <!-- Tailwind via CDN + custom layer -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome (optional but adds flavour) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-slate-50/60 font-sans antialiased">
    <div class="min-h-screen bg-white flex">
        <!-- LEFT SIDE - Login Form (30%) -->
        <div class="w-[30%] min-h-screen flex items-center justify-center px-8 py-12 bg-white">
            <div class="w-full max-w-sm mx-auto">
                
                <!-- Logo -->
                <div class="mb-8 text-center">
                    <div class="flex items-center justify-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#FF7543] to-[#FF8F65] flex items-center justify-center shadow-lg shadow-[#FF7543]/30">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-[#1a237e] tracking-tight">
                            Job<span class="text-[#FF7543]">Genie</span>
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">The Smart Recruiter</p>
                </div>

                <!-- Heading -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-[#1a237e]">Welcome Back!</h3>
                    <p class="text-sm text-gray-500 mt-1">Sign in to your account to continue</p>
                </div>

                <!-- Login Form -->
                <form action="{{route('auth.user.login.validate')}}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email/Phone -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address or Phone number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 text-sm"></i>
                            </div>
                            <input
                                type="text"
                                id="email"
                                name="email"
                                required
                                placeholder="Enter your email or phone"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400 text-sm"
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Enter your password"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400 text-sm"
                            >
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 text-sm hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Forgot Password & Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="w-4 h-4 text-[#1a237e] border-gray-300 rounded focus:ring-[#1a237e]"
                            >
                            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-[#FF7543] hover:underline font-medium">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full py-3.5 bg-[#1a237e] hover:bg-[#0d1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1a237e]/20 hover:shadow-xl hover:shadow-[#1a237e]/30 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-3">
                    <button class="w-full py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2 text-sm font-medium text-gray-700">
                        <i class="fab fa-google text-red-500"></i>
                        Google
                    </button>
                    <button class="w-full py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2 text-sm font-medium text-gray-700">
                        <i class="fab fa-linkedin-in text-blue-600"></i>
                        LinkedIn
                    </button>
                </div>

                <!-- Create Account Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="#" class="text-[#FF7543] font-semibold hover:underline hover:text-[#e0663a] transition-colors">
                            Create one
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - Image/Content (70%) -->
        <div class="w-[70%] min-h-screen relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#1a237e] to-[#0d1445]">
                <img 
                    src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                    alt="Team working together" 
                    class="w-full h-full object-cover opacity-60"
                >
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-tl from-[#1a237e]/90 via-[#1a237e]/60 to-transparent"></div>
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 h-full flex flex-col items-center justify-center px-12 text-center text-white">
                <!-- Decorative Icon -->
                <div class="mb-6">
                    <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                        <i class="fas fa-users text-4xl text-white/80"></i>
                    </div>
                </div>

                <!-- Heading -->
                <h2 class="text-4xl font-bold mb-4 leading-tight">
                    Connect with <br class="hidden sm:block">
                    <span class="text-[#FF7543]">Top Talent</span> Today
                </h2>

                <!-- Description -->
                <p class="text-lg text-white/80 max-w-md mb-8">
                    Join thousands of companies finding the perfect candidates for their teams. Start your journey with JobGenie now.
                </p>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 w-full max-w-lg">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">10K+</div>
                        <div class="text-sm text-white/60">Active Jobs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">50K+</div>
                        <div class="text-sm text-white/60">Candidates</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">4.9★</div>
                        <div class="text-sm text-white/60">Rating</div>
                    </div>
                </div>

                <!-- Features List -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4 text-sm text-white/70">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-[#FF7543]"></i>
                        Easy Apply
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-[#FF7543]"></i>
                        Verified Companies
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-[#FF7543]"></i>
                        24/7 Support
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>    

