<?php

declare(strict_types=1);

namespace App\Events\Panel\Members;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class MemberStatusUpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $user,
        public readonly User $causer,
        public readonly UserStatus $oldStatus,
        public readonly UserStatus $newStatus,
    ) {}
}
