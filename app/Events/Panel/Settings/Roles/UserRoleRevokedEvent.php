<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Roles;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRoleRevokedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly User $causer,
        public readonly string $roleName,
    ) {}
}
