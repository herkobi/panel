<?php

declare(strict_types=1);

namespace App\Events\Panel\Settings\User;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class UserEmailChangeConfirmedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $user,
        public readonly string $oldEmail,
        public readonly string $newEmail,
    ) {}
}
