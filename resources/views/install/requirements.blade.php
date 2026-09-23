<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Requirements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-3xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-[#1A237E] mb-6">Server Requirements</h1>

    <div class="space-y-6">
        {{-- PHP Version --}}
        <div>
            <h3 class="text-sm font-bold text-gray-800 mb-2">PHP Version</h3>
            <div class="flex items-center justify-between p-3 rounded-lg {{ $requirements['php_version']['pass'] ? 'bg-emerald-50' : 'bg-red-50' }}">
                <span class="text-sm text-gray-700">{{ $requirements['php_version']['label'] }}</span>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium {{ $requirements['php_version']['pass'] ? 'text-emerald-700' : 'text-red-700' }}">
                        {{ $requirements['php_version']['value'] }}
                    </span>
                    <span class="text-lg">{{ $requirements['php_version']['pass'] ? '✅' : '❌' }}</span>
                </div>
            </div>
        </div>

        {{-- Extensions --}}
        <div>
            <h3 class="text-sm font-bold text-gray-800 mb-2">PHP Extensions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($requirements['extensions'] as $ext)
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $ext['pass'] ? 'bg-emerald-50' : 'bg-red-50' }}">
                        <span class="text-sm text-gray-700">{{ $ext['label'] }}</span>
                        <span class="text-lg">{{ $ext['pass'] ? '✅' : '❌' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Permissions --}}
        <div>
            <h3 class="text-sm font-bold text-gray-800 mb-2">Folder Permissions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($requirements['permissions'] as $perm)
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $perm['pass'] ? 'bg-emerald-50' : 'bg-red-50' }}">
                        <span class="text-sm text-gray-700">{{ $perm['label'] }}</span>
                        <span class="text-lg">{{ $perm['pass'] ? '✅' : '❌' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-8 flex items-center justify-between">
        <a href="{{ route('install.welcome') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back</a>

        @if($requirements['all_pass'])
            <a href="{{ route('install.database') }}"
               class="px-6 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
                Continue →
            </a>
        @else
            <button disabled
                    class="px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-xl cursor-not-allowed">
                Fix Requirements First
            </button>
        @endif
    </div>
</div>

</body>
</html>