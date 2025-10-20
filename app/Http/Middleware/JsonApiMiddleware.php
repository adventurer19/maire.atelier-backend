<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Гарантира, че всички API заявки и отговори са в JSON формат
     * Автоматично сетва правилните headers за JSON API
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Форсирай JSON Accept header ако липсва
        if (!$request->header('Accept')) {
            $request->headers->set('Accept', 'application/json');
        }

        // Добави JSON header към заявката ако е POST/PUT/PATCH с данни
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH']) && !$request->header('Content-Type')) {
            $request->headers->set('Content-Type', 'application/json');
        }

        $response = $next($request);

        // Сетни JSON Content-Type на отговора
        if ($response instanceof Response) {
            $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        }

        return $response;
    }
}
