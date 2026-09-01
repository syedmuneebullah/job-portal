@extends('user.layouts.app')
@section('content')

<main class="bg-white min-h-screen py-16 md:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ===== HEADER ===== -->
        <div class="text-center mb-12">
            <span class="inline-block text-xs font-semibold text-[#FF7543] bg-[#FF7543]/10 px-4 py-1.5 rounded-full uppercase tracking-wider mb-4">
                Join Us Today
            </span>
            <h1 class="text-3xl md:text-5xl font-bold text-[#1a237e] leading-tight mb-4">
                Join SwiftAI Recruit
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm md:text-base">
                Choose how you want to use the platform. Connecting top talent with world-class organizations.
            </p>
        </div>

        <!-- ===== ROLE SELECTION CARDS ===== -->
        <div id="selection-section" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

            <!-- Job Seeker Card -->
            <button type="button" onclick="showForm('seeker')" id="card-seeker" class="group relative bg-white rounded-3xl p-8 text-left border-2 border-gray-100 hover:border-[#1a237e] transition-all duration-300 shadow-sm hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-[#1a237e]/20">
                <div class="absolute top-4 right-4 hidden group-hover:block text-[#1a237e]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                    </svg>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-[#1a237e]/10 flex items-center justify-center text-[#1a237e] mb-6 group-hover:bg-[#1a237e] group-hover:text-white transition-all duration-300">
                    <i class="fas fa-user-tie text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#1a237e] mb-3">I'm a Job Seeker</h3>
                <p class="text-gray-500 leading-relaxed mb-6">
                    Find your dream job, track applications, and get AI-powered career advice.
                </p>
                <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#1a237e] group-hover:gap-3 transition-all">
                    Select as Job Seeker <i class="fas fa-arrow-right"></i>
                </span>
            </button>

            <!-- Hiring Card -->
            <button type="button" onclick="showForm('hiring')" id="card-hiring" class="group relative bg-white rounded-3xl p-8 text-left border-2 border-gray-100 hover:border-[#FF7543] transition-all duration-300 shadow-sm hover:shadow-2xl hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-[#FF7543]/20">
                <div class="absolute top-4 right-4 hidden group-hover:block text-[#FF7543]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>
                    </svg>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-[#FF7543]/10 flex items-center justify-center text-[#FF7543] mb-6 group-hover:bg-[#FF7543] group-hover:text-white transition-all duration-300">
                    <i class="fas fa-building text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#1a237e] mb-3">I'm Hiring</h3>
                <p class="text-gray-500 leading-relaxed mb-6">
                    Post jobs, discover ranked candidates, and streamline your entire hiring process.
                </p>
                <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#FF7543] group-hover:gap-3 transition-all">
                    Select as Employer <i class="fas fa-arrow-right"></i>
                </span>
            </button>
        </div>

        <!-- ===== REGISTRATION FORMS (Hidden by default) ===== -->
        <div class="max-w-2xl mx-auto">

            <!-- Job Seeker Form -->
            <div id="form-seeker" class="hidden bg-white rounded-3xl border border-gray-200 shadow-2xl shadow-gray-200/50 p-8 md:p-10">

                <!-- Back Button -->
                <button type="button" onclick="hideForm()" class="inline-flex items-center gap-2 text-sm font-semibold text-[#1a237e] hover:text-[#0d1445] mb-6 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    Back to Selection
                </button>

                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-[#1a237e]">Job Seeker Registration</h2>
                </div>

                <form action="{{route('auth.user.validate')}}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="job_seeker">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">First Name</label>
                            <input type="text" name="first_name" required placeholder="John" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Last Name</label>
                            <input type="text" name="last_name" required placeholder="Doe" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#1a237e] mb-2">Email Address</label>
                        <input type="email" name="email" required placeholder="john@example.com" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Password</label>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#1a237e] hover:bg-[#0d1445] text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#1a237e]/20 hover:shadow-xl hover:-translate-y-0.5">
                        Create Job Seeker Account
                    </button>
                </form>
            </div>

            <!-- Hiring Form -->
            <div id="form-hiring" class="hidden bg-white rounded-3xl border border-gray-200 shadow-2xl shadow-gray-200/50 p-8 md:p-10">

                <!-- Back Button -->
                <button type="button" onclick="hideForm()" class="inline-flex items-center gap-2 text-sm font-semibold text-[#FF7543] hover:text-[#E65C00] mb-6 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    Back to Selection
                </button>

                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-[#1a237e]">Employer Registration</h2>
                </div>

                <form action="{{route('auth.user.validate')}}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="employer">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">First Name</label>
                            <input type="text" name="first_name" required placeholder="John" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Last Name</label>
                            <input type="text" name="last_name" required placeholder="Doe" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#1a237e] mb-2">Company Name</label>
                        <input type="text" name="company_name" required placeholder="TechCorp Malaysia" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#FF7543] focus:ring-2 focus:ring-[#FF7543]/10 outline-none transition-all placeholder-gray-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#1a237e] mb-2">Work Email</label>
                        <input type="email" name="email" required placeholder="hr@company.com" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#FF7543] focus:ring-2 focus:ring-[#FF7543]/10 outline-none transition-all placeholder-gray-400">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Password</label>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#FF7543] focus:ring-2 focus:ring-[#FF7543]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#1a237e] mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#FF7543] focus:ring-2 focus:ring-[#FF7543]/10 outline-none transition-all placeholder-gray-400">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#FF7543] hover:bg-[#E65C00] text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#FF7543]/20 hover:shadow-xl hover:-translate-y-0.5">
                        Create Employer Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- ===== JAVASCRIPT ===== -->
<script>
    function showForm(role) {
        // Hide selection cards section
        document.getElementById('selection-section').classList.add('hidden');

        // Hide both forms first
        document.getElementById('form-seeker').classList.add('hidden');
        document.getElementById('form-hiring').classList.add('hidden');

        // Show selected form
        const selectedForm = document.getElementById('form-' + role);
        selectedForm.classList.remove('hidden');

        // Smooth scroll to form
        selectedForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function hideForm() {
        // Hide all forms
        document.getElementById('form-seeker').classList.add('hidden');
        document.getElementById('form-hiring').classList.add('hidden');

        // Show selection cards again
        document.getElementById('selection-section').classList.remove('hidden');

        // Smooth scroll back to selection
        document.getElementById('selection-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
</script>

@endsection
