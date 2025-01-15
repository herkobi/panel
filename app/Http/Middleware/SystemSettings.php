<?php

namespace App\Http\Middleware;

use App\Facades\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SystemSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dil ayarı
        if ($language = Setting::get('language')) {
            App::setLocale($language);
        }

        // Zaman dilimi ayarı
        if ($timezone = Setting::get('timezone')) {
            date_default_timezone_set($timezone);
            config(['app.timezone' => $timezone]);
        }

        // Para birimi ayarı
        if ($currency = Setting::get('currency')) {
            config(['app.currency' => $currency]);
        }

        // Vergi oranı ayarı
        if ($tax = Setting::get('tax')) {
            config(['app.tax' => $tax]);
        }

        // Konum ayarı
        if ($location = Setting::get('location')) {
            config(['app.location' => $location]);
        }

        // Tarih ve saat formatı ayarları
        if ($dateFormat = Setting::get('dateformat')) {
            Carbon::setLocale($language ?? config('app.locale'));
            config(['app.date_format' => $dateFormat]);
        }

        if ($timeFormat = Setting::get('timeformat')) {
            config(['app.time_format' => $timeFormat]);
        }

        return $next($request);
    }
}
