<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\Language;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class System
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $language = config('panel.language');
        $timezone = config('panel.timezone');

        if ($user) {
            $user_settings = json_decode($user->settings, true) ?? [];

            $language = $user_settings['language'] ?? $language;
            $timezone = $user_settings['timezone'] ?? $timezone;

            $languages = Language::where('status', Status::ACTIVE)->pluck('code')->toArray();
            $language = in_array($language, $languages) ? $language : $language;
        }

        $this->setLocaleAndTimezone($language, $timezone);

        return $next($request);
    }

    private function setLocaleAndTimezone(string $language, string $timezone)
    {
        Session::put('locale', $language);
        app()->setLocale($language);
        date_default_timezone_set($timezone);
    }

}
