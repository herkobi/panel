<?php

declare(strict_types=1);

namespace App\Events\App\Profile;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class PasswordUpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $updatedBy,
    ) {}
}
