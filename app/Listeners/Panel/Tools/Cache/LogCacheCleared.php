<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Cache;

use App\Events\Panel\Tools\Cache\CacheClearedEvent;

class LogCacheCleared
{
    public function handle(CacheClearedEvent $event): void
    {
        $userName = $event->causer->name;

        $cacheName = match ($event->type) {
            'application' => 'Uygulama Önbelleğini',
            'config' => 'Yapılandırma Önbelleğini',
            'route' => 'Rota Önbelleğini',
            'view' => 'Görünüm Önbelleğini',
            'event' => 'Olay Önbelleğini',
            'compiled' => 'Derlenmiş Önbelleği',
            'all' => 'Tüm Önbelleği',
            default => $event->type,
        };

        activity('cache')
            ->causedBy($event->causer)
            ->event('cleared')
            ->withProperties(['type' => $event->type])
            ->log("{$userName} {$cacheName} temizledi.");
    }
}
