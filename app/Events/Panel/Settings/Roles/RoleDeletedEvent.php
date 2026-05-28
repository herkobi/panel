<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\Roles;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string $roleName,
        public readonly User $causer,
    ) {}
}
