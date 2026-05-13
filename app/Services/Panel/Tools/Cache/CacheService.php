<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Cache;

use App\Events\Panel\Tools\Cache\CacheClearedEvent;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class CacheService
{
    /**
     * @return array<string, string>
     */
    public function clear(string $type, User $causer): array
    {
        $command = match ($type) {
            'application' => 'cache:clear',
            'config' => 'config:clear',
            'route' => 'route:clear',
            'view' => 'view:clear',
            'event' => 'event:clear',

            'compiled' => 'clear-compiled',
            default => throw new \InvalidArgumentException("Bilinmeyen cache türü: {$type}"),
        };

        Artisan::call($command);

        CacheClearedEvent::dispatch($type, $causer);

        return [
            'type' => $type,
            'command' => $command,
            'output' => trim(Artisan::output()),
        ];
    }

    public function clearAll(User $causer): void
    {
        Artisan::call('optimize:clear');

        CacheClearedEvent::dispatch('all', $causer);
    }
}
