<?php

namespace App\Http\Middleware;

use App\Models\Settings as Panel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $default_settings = Panel::pluck('value', 'key')->toArray();
        $user_settings = json_decode(Auth::user()->settings, true);

        $language = $user_settings['language'] ? $user_settings['language'] : $default_settings['language'];

        if (!empty($language)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
