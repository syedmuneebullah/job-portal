{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('user.layouts.app')

@section('content')
<main class="bg-slate-50/50 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        <!-- Brand -->
        <div class="text-center mb-6">
            <a href="{{ route('user.home') }}" class="inline-block">
                <h1 class="text-2xl font-bold text-[#1A237E]">Swift<span class="text-[#ff7543]">AI</span>Recruit</h1>
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">

            <!-- Icon -->
            <div class="w-14 h-14 rounded-2xl bg-[#ff7543]/10 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-[#ff7543]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-900 text-center">Forgot your password?</h2>
            <p class="text-sm text-gray-500 text-center mt-2 mb-6">
                No worries. Enter your email address and we'll send you a link to reset your password.
            </p>

            <!-- Success message -->
            @if(session('status'))
                <div class="mb-5 flex items-start gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
                    <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('auth.password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="email"
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#ff7543]/30 focus:border-[#ff7543] outline-none transition-all text-sm @error('email') border-red-500 @enderror"
                               placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Send reset link
                </button>
            </form>

            <!-- Back to login -->
            <p class="text-sm text-center text-gray-500 mt-6">
                Remember your password?
                <a href="{{ route('auth.user.login') }}" class="font-semibold text-[#1A237E] hover:text-[#ff7543] transition-colors">
                    Back to login
                </a>
            </p>
        </div>

        <!-- Footer note -->
        <p class="text-xs text-center text-gray-400 mt-4">
            For security reasons, reset links expire in 60 minutes.
        </p>
    </div>
</main>
@endsection