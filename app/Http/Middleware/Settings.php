<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Settings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return $next($request);
        }

        $language = auth()->user()->settings->language;
        $timezone = auth()->user()->settings->timezone;

        if (!empty($language)) {
            app()->setLocale($language);
        }

        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}
