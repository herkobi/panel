<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->status === AccountStatus::DRAFT || Auth::user()->type === UserType::DEMO))
        {
            if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
                return redirect()->back()->withErrors(['error' => 'Hesabınız dondurulmuş durumda. Bu işlemi gerçekleştiremezsiniz.']);
            }
        }

        return $next($request);
    }
}
