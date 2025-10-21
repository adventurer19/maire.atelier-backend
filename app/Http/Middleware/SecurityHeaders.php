<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        return $response;

        // 🔒 Основни HTTP Shield headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // предотвратява clickjacking
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // защита срещу MIME sniffing
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // XSS защита
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // ограничава referrer info
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()'); // ограничава API достъпи
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload'); // HSTS (работи само ако имаш HTTPS)
        $response->headers->set('Content-Security-Policy', "default-src 'self'; img-src * data:; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"); // CSP защита

    }
}
