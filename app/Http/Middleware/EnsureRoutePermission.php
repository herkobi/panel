<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Panel rotalarına otomatik yetki kontrolü uygular: rota adı = permission adı.
 *
 * Super Admin Gate::before üzerinden hepsini geçer. Diğer kullanıcılar yalnızca
 * kendilerine atanmış izinli rotalara erişebilir. Burası dışında ek bir middleware
 * koymaya gerek yok — yeni rota eklemek tek başına onu otomatik korumaya alır.
 *
 * Yeni keşfedilen rotalarda izin DB'de henüz yoksa yalnız Super Admin erişebilir;
 * admin "Yetkiler" UI'sinden "Rotalardan keşfet" ile o izni ekler ve istenen
 * rollere atayabilir.
 */
class EnsureRoutePermission
{
    /**
     * Yetki kontrolünden muaf rota adları (giriş noktaları vb.).
     */
    private const EXEMPT_ROUTE_NAMES = [
        'panel.dashboard',
    ];

    /**
     * Yetki kontrolünden muaf rota ön ekleri. Kişiye özel alanlar (kendi profili,
     * güvenlik, oturumlar, bildirimler) izinle yönetilmez; her panel kullanıcısı
     * kendi bilgilerine erişebilir.
     */
    private const EXEMPT_ROUTE_PREFIXES = [
        'panel.profile.',
    ];

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $name = $request->route()?->getName();

        if ($name === null || $this->isExempt($name)) {
            return $next($request);
        }

        $user = $request->user();

        abort_unless($user !== null && $user->can($name), 403);

        return $next($request);
    }

    private function isExempt(string $name): bool
    {
        if (in_array($name, self::EXEMPT_ROUTE_NAMES, true)) {
            return true;
        }

        foreach (self::EXEMPT_ROUTE_PREFIXES as $prefix) {
            if (str_starts_with($name, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
