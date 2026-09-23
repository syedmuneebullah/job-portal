<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Installation Complete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8 text-center">
    <div class="w-20 h-20 bg-emerald-100 rounded-full mx-auto flex items-center justify-center mb-4">
        <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-3">Installation Complete! 🎉</h1>
    <p class="text-gray-600 mb-8">
        Your application is now ready to use. You can login with your super admin credentials.
    </p>

    <div class="text-left bg-emerald-50 border border-emerald-200 rounded-xl p-5 mb-8">
        <h3 class="font-semibold text-emerald-800 mb-2">Next Steps:</h3>
        <ul class="space-y-1 text-sm text-emerald-700">
            <li>✅ Login as super admin</li>
            <li>✅ Configure your site further</li>
            <li>✅ Invite team members</li>
        </ul>
    </div>

    <a href="{{ url('/login') }}"
       class="inline-block px-8 py-3 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-xl transition-all">
        Go to Login →
    </a>

    <p class="text-xs text-gray-400 mt-6">
        <strong>Security Tip:</strong> Delete <code class="bg-gray-100 px-1 rounded">storage/installed.lock</code> file to prevent re-installation. Also consider removing the <code class="bg-gray-100 px-1 rounded">/install</code> routes in production.
    </p>
</div>

</body>
</html>