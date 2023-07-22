<?php

namespace App\Http\Middleware;

use App\Models\Settings as Panel;
use App\Models\Settings as ModelsSettings;
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

        /**
         * Oturum açan kullanıcının dil yapısı sisteme tanımlanır ve bu sayede
         * tüm yapı kullanıcının seçmiş olduğu dile göre gösterilir.
         *
         * Dil değeri kullanıcı tarafından sağlanmışsa yüklenir yoksa sistem ayarlarındaki
         * dil değeri yüklenir.
         *
         * Yine kullanıcının timezone değerine göre zaman dili yükleniyor
         */
        $default_settings = Panel::pluck('value', 'key');
        $user_settings = json_decode(Auth::user()->settings, true);

        $language = $user_settings['language'] ? $user_settings['language'] : $default_settings['language'];
        $timezone = $user_settings['timezone'] ? $user_settings['timezone'] : $default_settings['timezone'];

        app()->setLocale($language); //Dil tanımlama
        date_default_timezone_set($timezone); //Zaman dilimi tanımlama

        return $next($request);
    }
}
