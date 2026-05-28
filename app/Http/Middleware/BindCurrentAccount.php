<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Member (app) alanında oturumdaki kullanıcının Account'unu container'a bağlar.
 *
 * `BelongsToAccount` global scope'u ve creating hook'u bu bağlamayı okur:
 * bağlıysa sorgular/yaratmalar otomatik bu account'a kısıtlanır. Panel (admin),
 * seeder, job gibi bu middleware'den geçmeyen bağlamlarda bağlama yapılmaz —
 * scope devreye girmez, admin cross-account çalışmaya devam eder.
 */
class BindCurrentAccount
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null && $user->account_id !== null) {
            $user->loadMissing('account');

            if ($user->account !== null) {
                app()->instance('account.current', $user->account);
            }
        }

        return $next($request);
    }
}
