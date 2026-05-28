<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Roles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RolePermissionsSyncedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  array<int, string>  $added
     * @param  array<int, string>  $removed
     */
    public function __construct(
        public readonly Role $role,
        public readonly User $causer,
        public readonly array $added,
        public readonly array $removed,
    ) {}
}
