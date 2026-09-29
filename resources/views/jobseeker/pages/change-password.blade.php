{{-- resources/views/jobseeker/pages/change-password.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Back link -->
    <a href="{{ route('candidate.profile') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1a237e] hover:underline mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to profile
    </a>

    <!-- ===== SUCCESS / ERROR BANNER ===== -->
    @if(session('success'))
        <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('candidate.profile.change-password.update') }}" method="POST" id="changePasswordForm">
        @csrf
        @method('PUT')

        <div class="space-y-4">

            <!-- ===== PAGE HEADER ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900">Change password</h2>
                <p class="text-sm text-gray-500 mt-1">Keep your account secure by using a strong password</p>
            </div>

            <!-- ===== PASSWORD FORM ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">

                <!-- Account info (read-only) -->
                <div class="flex items-center gap-4 pb-6 mb-6 border-b border-gray-100">
                    <div class="w-14 h-14 rounded-full border-2 border-gray-100 bg-[#1a237e] flex items-center justify-center overflow-hidden shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/'.$user->profile_photo) }}"
                                 alt="{{ $user->full_name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-bold text-white">{{ $user->initials }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $user->full_name ?? $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <h3 class="text-base font-semibold text-gray-900 mb-4">Update your password</h3>

                <div class="space-y-5 max-w-2xl">

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Current password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password"
                                   autocomplete="current-password"
                                   class="w-full px-4 py-2 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('current_password') border-red-500 @enderror"
                                   placeholder="Enter your current password">
                            <button type="button" tabindex="-1"
                                    class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                    data-target="current_password">
                                <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            New password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                   autocomplete="new-password"
                                   class="w-full px-4 py-2 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('password') border-red-500 @enderror"
                                   placeholder="Enter your new password">
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

                        <!-- Password strength meter -->
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

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm new password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   autocomplete="new-password"
                                   class="w-full px-4 py-2 pr-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all"
                                   placeholder="Re-enter your new password">
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

                </div>
            </div>

            <!-- ===== SECURITY TIPS ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1a237e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Security tips
                </h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7543] mt-2 shrink-0"></span>
                        Use a unique password that you don't use on other websites
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7543] mt-2 shrink-0"></span>
                        Combine uppercase, lowercase, numbers, and symbols
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7543] mt-2 shrink-0"></span>
                        Never share your password with anyone
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ff7543] mt-2 shrink-0"></span>
                        Consider using a password manager for stronger security
                    </li>
                </ul>
            </div>

            <!-- ===== SUBMIT BUTTONS ===== -->
            <div class="flex items-center gap-3 pb-2">
                <button type="submit" id="submitBtn"
                        class="px-6 py-2.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed inline-flex items-center gap-2">
                    <svg id="submitSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="submitText">Update password</span>
                </button>
                <a href="{{ route('candidate.profile') }}" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-full hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>

        </div>
    </form>
</div>

<script>
(function () {
    // ===== SHOW / HIDE PASSWORD TOGGLES =====
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = btn.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (!input) return;

            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    });

    // ===== PASSWORD STRENGTH METER =====
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

    function updateRuleUI(ruleKey, passed) {
        const el = ruleEls[ruleKey];
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

        // Strength bar
        let percent = 0;
        let label = '—';
        let color = 'bg-gray-300';

        if (value.length > 0) {
            percent = (passed / 4) * 100;
            if (passed <= 1)      { label = 'Weak';   color = 'bg-red-500'; }
            else if (passed === 2){ label = 'Fair';   color = 'bg-orange-500'; }
            else if (passed === 3){ label = 'Good';   color = 'bg-yellow-500'; }
            else                  { label = 'Strong'; color = 'bg-emerald-500'; }
        }

        strengthBar.style.width = percent + '%';
        strengthBar.className = 'h-full rounded-full transition-all duration-300 ' + color;
        strengthLabel.textContent = label;
        strengthLabel.className = 'text-xs font-medium min-w-[70px] text-right ' +
            (passed >= 3 ? 'text-emerald-600' : passed >= 1 ? 'text-orange-500' : 'text-gray-400');
    }

    if (passwordInput) passwordInput.addEventListener('input', updateStrength);

    // ===== CONFIRM PASSWORD MATCH =====
    const confirmInput = document.getElementById('password_confirmation');
    const matchMsg = document.getElementById('matchMsg');

    function checkMatch() {
        if (!confirmInput.value) {
            matchMsg.classList.add('hidden');
            return;
        }
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

    // ===== SUBMIT — show spinner =====
    const form = document.getElementById('changePasswordForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    if (form) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Updating...';
        });
    }
})();
</script>

@endsection