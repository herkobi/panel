<?php

declare(strict_types=1);

namespace App\Events\Panel\Members;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class MemberCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $user,
        public readonly User $causer,
        public readonly bool $emailVerified,
    ) {}
}
