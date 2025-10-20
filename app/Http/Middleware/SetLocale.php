<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Automatically switches language based on:
     * 1. Session locale (for Filament admin panel)
     * 2. X-Locale header (for Next.js frontend)
     * 3. Accept-Language header (browser default)
     * 4. ?lang=bg query parameter
     * 5. APP_LOCALE from .env (fallback)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Check session first (for Filament admin panel persistence)
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }

        // 2. Check for X-Locale header (for Next.js)
        if (!$locale && $request->hasHeader('X-Locale')) {
            $locale = $request->header('X-Locale');
        }

        // 3. Check for Accept-Language header
        if (!$locale && $request->hasHeader('Accept-Language')) {
            $locale = $this->parseAcceptLanguage($request->header('Accept-Language'));
        }

        // 4. Check for query parameter (?lang=bg)
        if (!$locale && $request->has('lang')) {
            $locale = $request->query('lang');
        }

        // Valid locales
        $availableLocales = config('app.available_locales', ['bg', 'en']);

        // Set locale only if valid
        if ($locale && in_array($locale, $availableLocales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Parse Accept-Language header
     *
     * Example: "bg-BG,bg;q=0.9,en;q=0.8" -> "bg"
     * Example: "en-US,en;q=0.9" -> "en"
     */
    private function parseAcceptLanguage(string $header): ?string
    {
        // Get first language from header
        $languages = explode(',', $header);

        if (empty($languages)) {
            return null;
        }

        // Extract only the main language code (bg from bg-BG)
        $primaryLanguage = explode('-', explode(';', $languages[0])[0])[0];

        return strtolower(trim($primaryLanguage));
    }
}
