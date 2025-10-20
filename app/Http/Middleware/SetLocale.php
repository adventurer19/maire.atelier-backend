<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Автоматично сменя езика според:
     * 1. Accept-Language header (приоритет)
     * 2. X-Locale header (алтернатива)
     * 3. ?lang=bg query параметър
     * 4. APP_LOCALE от .env (default)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Проверка за X-Locale header (за Next.js по-лесно)
        if ($request->hasHeader('X-Locale')) {
            $locale = $request->header('X-Locale');
        }

        // 2. Проверка за Accept-Language header
        if (!$locale && $request->hasHeader('Accept-Language')) {
            $locale = $this->parseAcceptLanguage($request->header('Accept-Language'));
        }

        // 3. Проверка за query параметър (?lang=bg)
        if (!$locale && $request->has('lang')) {
            $locale = $request->query('lang');
        }

        // Валидни езици
        $availableLocales = config('app.available_locales', ['bg', 'en']);

        // Сетни езика само ако е валиден
        if ($locale && in_array($locale, $availableLocales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Parse Accept-Language header
     *
     * Пример: "bg-BG,bg;q=0.9,en;q=0.8" -> "bg"
     * Пример: "en-US,en;q=0.9" -> "en"
     */
    private function parseAcceptLanguage(string $header): ?string
    {
        // Вземи първия език от header-а
        $languages = explode(',', $header);

        if (empty($languages)) {
            return null;
        }

        // Извади само основния език код (bg от bg-BG)
        $primaryLanguage = explode('-', explode(';', $languages[0])[0])[0];

        return strtolower(trim($primaryLanguage));
    }
}
