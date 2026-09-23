<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $installed = file_exists(storage_path('installed.lock'));

        // ✅ Install routes ka special handling
        if ($request->is('install*')) {
            // Sirf /install (root) pe redirect karo agar already installed hai
            // /install/complete aur baaki sub-routes ko allow karo
            if ($installed && ($request->is('install') || $request->is('install/'))) {
                return redirect('/');
            }

            return $next($request);
        }

        // API routes skip
        if ($request->is('api/*')) {
            return $next($request);
        }

        // Install nahi hua to wizard pe bhejo
        if (!$installed) {
            return redirect()->route('install.welcome');
        }

        return $next($request);
    }
}