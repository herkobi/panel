<?php

declare(strict_types=1);

namespace App\Events\Panel\Profile;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class PreferencesUpdatedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $updatedBy,
    ) {}
}
