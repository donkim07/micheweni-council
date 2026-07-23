<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session or use browser's preferred language or default to app locale
        $locale = Session::get('locale');
        
        if (!$locale) {
            $locale = $request->getPreferredLanguage(
                Config::get('app.supported_locales', ['en'])
            );
        }
        
        // Ensure the locale is supported
        if (!in_array($locale, Config::get('app.supported_locales', ['en']))) {
            $locale = Config::get('app.fallback_locale', 'en');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}
