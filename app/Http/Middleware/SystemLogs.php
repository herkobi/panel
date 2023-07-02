<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemLogs
{
    public function handle(Request $request, Closure $next)
    {

        /**
         * Super Admin rolüne sahip süper admin kullanıcısı için
         * tüm yapılara erişim sağlandı.
         *
         * Super Admin dışındaki erişimler için 401 Yetkisiz Erişim hatası gösteriliyor
         */

        if (Auth::check() && Auth::user()->hasRole('Super Admin')) {
            return $next($request);
        }

        abort(401, 'Unauthorised');
    }
}
