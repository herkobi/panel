<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\General;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class SettingsUpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $causer,
    ) {}
}
