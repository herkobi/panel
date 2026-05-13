<?php

declare(strict_types=1);

namespace App\Events\App\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class AccountUpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Account $account,
        public readonly User $updatedBy,
    ) {}
}
