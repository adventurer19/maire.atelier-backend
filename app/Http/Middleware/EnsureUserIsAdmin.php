<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Проверява дали потребителят е Admin или Super Admin
     * Използва се за защита на admin API endpoints
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'error' => 'AUTH_REQUIRED'
            ], 401);
        }

        if (!$request->user()->role->canAccessAdmin()) {
            return response()->json([
                'message' => 'Forbidden. Admin access required.',
                'error' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        return $next($request);
    }
}
