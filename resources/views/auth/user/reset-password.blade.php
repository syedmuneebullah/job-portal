{{-- resources/views/auth/reset-password.blade.php --}}
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
            <div class="w-14 h-14 rounded-2xl bg-[#1A237E]/10 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-[#1A237E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-900 text-center">Set new password</h2>
            <p class="text-sm text-gray-500 text-center mt-2 mb-6">
                Choose a strong password to keep your account secure.
            </p>

            <!-- Form -->
            <form method="POST" action="{{ route('auth.password.update') }}" class="space-y-4" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
                           required autocomplete="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-600 focus:ring-2 focus:ring-[#ff7543]/30 focus:border-[#ff7543] outline-none transition-all text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        New password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                               required autocomplete="new-password"
                               class="w-full px-4 py-3 pr-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#ff7543]/30 focus:border-[#ff7543] outline-none transition-all text-sm @error('password') border-red-500 @enderror"
                               placeholder="Enter new password">
                        <button type="button" tabindex="-1"
                                class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                data-target="password">
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <!-- Strength meter -->
                    <div class="mt-3">
                        <div class="flex items-center gap-2 mb-1.5">
                            <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full w-0 rounded-full transition-all duration-300"></div>
                            </div>
                            <span id="strengthLabel" class="text-xs font-medium text-gray-400 min-w-[70px] text-right">—</span>
                        </div>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                            <li class="flex items-center gap-1.5" data-rule="length">
                                <span class="rule-dot w-3.5 h-3.5 rounded-full border border-gray-300 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white hidden rule-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                At least 8 characters
                            </li>
                            <li class="flex items-center gap-1.5" data-rule="mixed">
                                <span class="rule-dot w-3.5 h-3.5 rounded-full border border-gray-300 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white hidden rule-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Upper &amp; lowercase
                            </li>
                            <li class="flex items-center gap-1.5" data-rule="number">
                                <span class="rule-dot w-3.5 h-3.5 rounded-full border border-gray-300 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white hidden rule-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                At least one number
                            </li>
                            <li class="flex items-center gap-1.5" data-rule="symbol">
                                <span class="rule-dot w-3.5 h-3.5 rounded-full border border-gray-300 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white hidden rule-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                At least one symbol
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Confirm password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm new password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               required autocomplete="new-password"
                               class="w-full px-4 py-3 pr-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#ff7543]/30 focus:border-[#ff7543] outline-none transition-all text-sm"
                               placeholder="Re-enter new password">
                        <button type="button" tabindex="-1"
                                class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                data-target="password_confirmation">
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p id="matchMsg" class="mt-1 text-sm hidden"></p>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-[#ff7543]/20 hover:shadow-xl hover:shadow-[#ff7543]/30 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Reset password
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
    </div>
</main>

<script>
(function () {
    // ===== SHOW / HIDE PASSWORD =====
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) return;
            const open = btn.querySelector('.eye-open');
            const closed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                open.classList.add('hidden');
                closed.classList.remove('hidden');
            } else {
                input.type = 'password';
                open.classList.remove('hidden');
                closed.classList.add('hidden');
            }
        });
    });

    // ===== PASSWORD STRENGTH =====
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthLabel = document.getElementById('strengthLabel');
    const ruleEls = {
        length: document.querySelector('[data-rule="length"]'),
        mixed: document.querySelector('[data-rule="mixed"]'),
        number: document.querySelector('[data-rule="number"]'),
        symbol: document.querySelector('[data-rule="symbol"]'),
    };

    function checkRules(value) {
        return {
            length: value.length >= 8,
            mixed: /[a-z]/.test(value) && /[A-Z]/.test(value),
            number: /\d/.test(value),
            symbol: /[^A-Za-z0-9]/.test(value),
        };
    }

    function updateRuleUI(key, passed) {
        const el = ruleEls[key];
        if (!el) return;
        const dot = el.querySelector('.rule-dot');
        const check = el.querySelector('.rule-check');
        if (passed) {
            dot.classList.remove('border-gray-300');
            dot.classList.add('bg-emerald-500', 'border-emerald-500');
            check.classList.remove('hidden');
            el.classList.remove('text-gray-500');
            el.classList.add('text-emerald-600');
        } else {
            dot.classList.add('border-gray-300');
            dot.classList.remove('bg-emerald-500', 'border-emerald-500');
            check.classList.add('hidden');
            el.classList.add('text-gray-500');
            el.classList.remove('text-emerald-600');
        }
    }

    function updateStrength() {
        const value = passwordInput.value;
        const rules = checkRules(value);
        const passed = Object.values(rules).filter(Boolean).length;

        Object.entries(rules).forEach(([k, v]) => updateRuleUI(k, v));

        let percent = 0, label = '—', color = 'bg-gray-300';
        if (value.length > 0) {
            percent = (passed / 4) * 100;
            if (passed <= 1)       { label = 'Weak';   color = 'bg-red-500'; }
            else if (passed === 2) { label = 'Fair';   color = 'bg-orange-500'; }
            else if (passed === 3) { label = 'Good';   color = 'bg-yellow-500'; }
            else                   { label = 'Strong'; color = 'bg-emerald-500'; }
        }

        strengthBar.style.width = percent + '%';
        strengthBar.className = 'h-full rounded-full transition-all duration-300 ' + color;
        strengthLabel.textContent = label;
        strengthLabel.className = 'text-xs font-medium min-w-[70px] text-right ' +
            (passed >= 3 ? 'text-emerald-600' : passed >= 1 ? 'text-orange-500' : 'text-gray-400');
    }

    if (passwordInput) passwordInput.addEventListener('input', updateStrength);

    // ===== CONFIRM MATCH =====
    const confirmInput = document.getElementById('password_confirmation');
    const matchMsg = document.getElementById('matchMsg');

    function checkMatch() {
        if (!confirmInput.value) { matchMsg.classList.add('hidden'); return; }
        matchMsg.classList.remove('hidden');
        if (confirmInput.value === passwordInput.value) {
            matchMsg.textContent = 'Passwords match';
            matchMsg.className = 'mt-1 text-sm text-emerald-600';
        } else {
            matchMsg.textContent = 'Passwords do not match';
            matchMsg.className = 'mt-1 text-sm text-red-500';
        }
    }

    if (confirmInput) confirmInput.addEventListener('input', checkMatch);
    if (passwordInput) passwordInput.addEventListener('input', checkMatch);
})();
</script>
@endsection