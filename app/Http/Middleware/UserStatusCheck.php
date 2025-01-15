<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserStatusCheck
{
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        // Account Status kontrolü
        if ($user->status === AccountStatus::DRAFT || $user->type === UserType::DEMO) {
            if ($request->isMethod('post') ||
                $request->isMethod('put') ||
                $request->isMethod('patch') ||
                $request->isMethod('delete')) {
                return redirect()->back()
                    ->withErrors(['error' => 'Hesabınız dondurulmuş durumda. Bu işlemi gerçekleştiremezsiniz.']);
            }
        }

        return $next($request);
    }
}
