<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-[#1A237E] mb-2">Create Super Admin</h1>
    <p class="text-sm text-gray-500 mb-6">Ye account aapke system ka super admin hoga.</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form action="{{ route('install.super-admin.save') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required minlength="8"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            <p class="text-xs text-gray-400 mt-1">Minimum 8 characters</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required minlength="8"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div class="pt-4 flex items-center justify-between">
            <a href="{{ route('install.app-config') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back</a>
            <button type="submit"
                    class="px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
                Continue →
            </button>
        </div>
    </form>
</div>

</body>
</html>