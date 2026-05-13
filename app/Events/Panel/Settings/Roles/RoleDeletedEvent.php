<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Roles;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class RoleDeletedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly string $roleName,
        public readonly User $causer,
    ) {}
}
