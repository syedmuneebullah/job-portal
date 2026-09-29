<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-[#1A237E] mb-2">Database Configuration</h1>
    <p class="text-sm text-gray-500 mb-6">Enter your MySQL database details.</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('install.database.save') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">DB Host</label>
                <input type="text" name="db_host" value="{{ old('db_host', '127.0.0.1') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Port</label>
                <input type="text" name="db_port" value="{{ old('db_port', '3306') }}"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database Name</label>
            <input type="text" name="db_name" value="{{ old('db_name') }}"
                   placeholder="e.g. swift_recruit"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database User</label>
            <input type="text" name="db_user" value="{{ old('db_user', 'root') }}"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Database Password</label>
            <input type="password" name="db_password" value="{{ old('db_password') }}"
                   placeholder="Leave empty if none"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#ff7543] focus:ring-1 focus:ring-[#ff7543]/30 outline-none">
        </div>

        <div class="pt-4 flex items-center justify-between">
            <a href="{{ route('install.requirements') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back</a>
            <button type="submit"
                    class="px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
                Test & Continue →
            </button>
        </div>
    </form>
</div>

</body>
</html>