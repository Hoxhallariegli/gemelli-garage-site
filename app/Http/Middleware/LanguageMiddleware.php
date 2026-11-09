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
            $acceptLang = strtolower($request->header('Accept-Language') ?? $request->server('HTTP_ACCEPT_LANGUAGE') ?? '');

            // 1. Check Country Code from Cloudflare or Web Server Proxy
            $country = strtoupper(
                $request->header('CF-IPCountry')
                ?? $request->header('X-Country-Code')
                ?? $request->server('HTTP_CF_IPCOUNTRY')
                ?? ''
            );

            if (in_array($country, ['AL', 'XK', 'MK'])) {
                $locale = 'sq';
            } elseif (in_array($country, ['IT', 'CH'])) {
                $locale = 'it';
            } elseif (str_contains($acceptLang, 'sq') || str_contains($acceptLang, 'al')) {
                // 2. If browser accepts Albanian anywhere in preference
                $locale = 'sq';
            } elseif (str_contains($acceptLang, 'it')) {
                // 3. If browser accepts Italian
                $locale = 'it';
            } else {
                // 4. Default fallback locale for local/test
                $locale = 'sq';
            }

            session()->put('locale', $locale);
            App::setLocale($locale);
        }

        return $next($request);
    }
}
