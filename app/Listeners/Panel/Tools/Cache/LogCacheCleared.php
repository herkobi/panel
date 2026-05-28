<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Cache;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Cache\CacheClearedEvent;

class LogCacheCleared
{
    use LogsActivity;

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

        $this->logActivity(
            logName: 'cache',
            causer: $event->causer,
            event: 'cleared',
            message: "{$userName} {$cacheName} temizledi.",
            properties: ['type' => $event->type],
        );
    }
}
