<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-2xl w-full bg-white rounded-2xl shadow-lg p-8 text-center">
    <div class="w-20 h-20 bg-[#1A237E] rounded-2xl mx-auto flex items-center justify-center mb-4">
        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-[#1A237E] mb-3">Welcome to Installation</h1>
    <p class="text-gray-600 mb-8">
        Ye wizard aapko application setup karne mein madad karega. Sirf 5 minute mein ready.
    </p>

    <div class="text-left bg-gray-50 rounded-xl p-5 mb-8">
        <h3 class="font-semibold text-gray-800 mb-3">Installation Steps:</h3>
        <ol class="space-y-2 text-sm text-gray-600">
            <li>✅ Server requirements check</li>
            <li>✅ Database configuration</li>
            <li>✅ Application settings</li>
            <li>✅ Super admin account create</li>
            <li>✅ Site settings</li>
        </ol>
    </div>

    <a href="{{ route('install.requirements') }}"
       class="inline-block px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
        Start Installation →
    </a>

    <p class="text-xs text-gray-400 mt-6">
        Make sure your server meets all requirements before starting.
    </p>
</div>

</body>
</html>