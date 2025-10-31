<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCartToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Cart-Token');

        if (!$token) {
            $token = (string) \Str::uuid();
        }

        // съхраняваме токена в request, за достъп от CartService
        $request->merge(['cart_token' => $token]);

        return $next($request);
    }
}
