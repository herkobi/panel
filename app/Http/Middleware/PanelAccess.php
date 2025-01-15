<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Traits\AuthUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PanelAccess
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $panelType): Response
    {
        if($panelType === 'admin' &&
            Auth::user()->type !== UserType::ADMIN &&
            Auth::user()->type !== UserType::SUPER) {
            return redirect('/app');
        }

        if($panelType === 'user' &&
            Auth::user()->type !== UserType::USER &&
            Auth::user()->type !== UserType::DEMO) {
            return redirect('/panel');
        }

        return $next($request);
    }
}
