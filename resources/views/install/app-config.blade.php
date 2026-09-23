<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-[#1A237E] mb-2">Application Settings</h1>
    <p class="text-sm text-gray-500 mb-6">Basic app and mail settings.</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('install.app-config.save') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Application Name</label>
            <input type="text" name="app_name" value="{{ old('app_name', 'SwiftRecruitAI') }}"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Application URL</label>
            <input type="url" name="app_url" value="{{ old('app_url', 'http://localhost') }}"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Environment</label>
                <select name="app_env"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
                    <option value="local" {{ old('app_env', 'local') === 'local' ? 'selected' : '' }}>Local</option>
                    <option value="production" {{ old('app_env') === 'production' ? 'selected' : '' }}>Production</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Debug Mode</label>
                <select name="app_debug"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
                    <option value="1" {{ old('app_debug', '1') === '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ old('app_debug') === '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
        </div>

        <h3 class="text-sm font-bold text-gray-800 pt-4 border-t border-gray-100">Mail Settings (Optional)</h3>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mail Host</label>
                <input type="text" name="mail_host" value="{{ old('mail_host') }}"
                       placeholder="smtp.mailtrap.io"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mail Port</label>
                <input type="text" name="mail_port" value="{{ old('mail_port', '587') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mail Username</label>
                <input type="text" name="mail_user" value="{{ old('mail_user') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mail Password</label>
                <input type="password" name="mail_password" value="{{ old('mail_password') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Email</label>
                <input type="email" name="mail_from_address" value="{{ old('mail_from_address') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
                <input type="text" name="mail_from_name" value="{{ old('mail_from_name') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between">
            <a href="{{ route('install.database') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back</a>
            <button type="submit"
                    class="px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
                Continue →
            </button>
        </div>
    </form>
</div>

</body>
</html>