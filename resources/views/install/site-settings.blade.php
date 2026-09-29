<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-[#1A237E] mb-2">Site Settings</h1>
    <p class="text-sm text-gray-500 mb-6">Basic site information.</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('install.site-settings.save') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
            <input type="text" name="site_name" value="{{ old('site_name', 'SwiftRecruitAI') }}" required
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
            <input type="text" name="site_tagline" value="{{ old('site_tagline') }}"
                   placeholder="Find your dream job..."
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Site Email</label>
                <input type="email" name="site_email" value="{{ old('site_email') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Site Phone</label>
                <input type="text" name="site_phone" value="{{ old('site_phone') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="site_address" rows="2"
                      class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">{{ old('site_address') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
                <select name="timezone"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
                    <option value="UTC">UTC</option>
                    <option value="Asia/Karachi" selected>Asia/Karachi</option>
                    <option value="Asia/Kolkata">Asia/Kolkata</option>
                    <option value="Asia/Dubai">Asia/Dubai</option>
                    <option value="Asia/Singapore">Asia/Singapore</option>
                    <option value="Europe/London">Europe/London</option>
                    <option value="America/New_York">America/New_York</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                <select name="currency"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
                    <option value="PKR">PKR</option>
                    <option value="USD">USD</option>
                    <option value="MYR" selected>MYR</option>
                    <option value="INR">INR</option>
                    <option value="AED">AED</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <a href="{{ route('install.super-admin') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back</a>
            <button type="submit"
                    class="px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
                Install Now →
            </button>
        </div>
    </form>
</div>

</body>
</html>