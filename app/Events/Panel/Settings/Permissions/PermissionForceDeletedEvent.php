<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Permissions;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class PermissionForceDeletedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly string $name,
        public readonly User $causer,
    ) {}
}
