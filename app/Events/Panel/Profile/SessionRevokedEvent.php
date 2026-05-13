<?php

declare(strict_types=1);

namespace App\Events\Panel\Profile;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class SessionRevokedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $updatedBy,
        public readonly ?string $ipAddress,
        public readonly ?string $userAgent,
    ) {}
}
