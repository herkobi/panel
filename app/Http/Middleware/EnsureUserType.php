<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userType = $request->user()->user_type;

        if (empty($types)) {
            return $next($request);
        }

        $allowedTypes = collect($types)->map(fn ($type) => UserType::tryFrom($type))->filter()->toArray();

        if (! in_array($userType, $allowedTypes, true)) {
            return redirect()->route('dashboard')->with('toast', ['type' => 'error', 'message' => __('auth.no_page_access')]);
        }

        return $next($request);
    }
}
