<?php

declare(strict_types=1);

namespace App\Events\Panel\Tools\Cache;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class CacheClearedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly string $type,
        public readonly User $causer,
    ) {}
}
