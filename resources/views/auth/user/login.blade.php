@extends('user.layouts.app')
@section('content')

<main class="min-h-screen bg-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full mx-auto">

        <!-- ===== LOGIN CARD ===== -->
        <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/60 border border-gray-100 p-8 sm:p-10">

            <!-- Logo & Heading -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-4">
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
            <h3 class="text-xl font-bold text-[#1a237e] mb-6">Sign in - Company</h3>

            <!-- Form -->
            <form action="" method="POST" class="space-y-5">
                @csrf

                <!-- Email/Phone -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address or Phone number</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        required
                        placeholder="Email or Phone number"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400 text-sm"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400 text-sm"
                    >
                </div>

                <!-- Forgot Password -->
                <div class="text-right">
                    <a href="#" class="text-sm text-[#FF7543] hover:underline">Forgot your password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full py-3.5 bg-[#1a237e] hover:bg-[#0d1445] text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#1a237e]/20 hover:shadow-xl hover:shadow-[#1a237e]/30 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>

            <!-- Create Account Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? <a href="#" class="text-[#FF7543] font-semibold hover:underline">Create one</a>
                </p>
            </div>
        </div>
    </div>
</main>

@endsection
