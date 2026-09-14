
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
                <div class="flex items-center gap-2 sm:gap-2.5 md:gap-3.5 mb-5 text-center">
                <!-- Logo -->
                <div class="flex items-center justify-center w-7 h-7 sm:w-9 sm:h-9 md:w-11 md:h-11 rounded-xl sm:rounded-2xl ring-1 ring-white/30 overflow-hidden flex-shrink-0">
                    <img
                        src="https://swiftairecruit.com/_next/image?url=%2Ficon.png&w=128&q=75"
                        alt="SwiftAI Recruit"
                        class="object-contain w-full h-full"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-brain text-white text-sm sm:text-base md:text-xl drop-shadow-sm\'></i>'"
                    />
                </div>
                <!-- text -->
                <div class="flex items-baseline">
                    <span class="text-base sm:text-xl md:text-2xl font-bold text-[#1A237E] whitespace-nowrap">Swift<span class="">AI</span> <span class="text-[#1A237E] ">Recruit</span></span>
                </div>
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

