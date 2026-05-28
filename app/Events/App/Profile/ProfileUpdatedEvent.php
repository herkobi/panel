<?php

declare(strict_types=1);

namespace App\Events\App\Profile;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfileUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly User $updatedBy,
        public readonly bool $emailChanged = false,
    ) {}
}
