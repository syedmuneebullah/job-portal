<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        if (!in_array($user->user_type, $types)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to access this resource.'
            ], 403);
        }

        return $next($request);
    }
}
