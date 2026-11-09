<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } else {
            // 1. Detect Country Code from Cloudflare or Proxy headers
            $country = strtoupper(
                $request->header('CF-IPCountry')
                ?? $request->header('X-Country-Code')
                ?? $request->server('HTTP_CF_IPCOUNTRY')
                ?? ''
            );

            if ($country === 'IT') {
                $locale = 'it';
            } elseif (in_array($country, ['AL', 'XK', 'MK'])) {
                $locale = 'sq';
            } else {
                // 2. Detect preferred language from Browser HTTP_ACCEPT_LANGUAGE header
                $preferred = $request->getPreferredLanguage(['it', 'sq', 'en']);
                $locale = $preferred ?: 'it'; // Default to Italian for Gemelli Garage
            }

            session()->put('locale', $locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
