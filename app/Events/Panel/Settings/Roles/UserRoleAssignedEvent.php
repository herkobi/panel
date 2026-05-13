<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Roles;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class UserRoleAssignedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $user,
        public readonly User $causer,
        public readonly string $roleName,
        public readonly ?string $previousRoleName = null,
    ) {}
}
