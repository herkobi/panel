<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Permissions;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class PermissionRestoredEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Permission $permission,
        public readonly User $causer,
    ) {}
}
