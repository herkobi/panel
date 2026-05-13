<?php

declare(strict_types=1);

namespace App\Events\Auth;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class NewDeviceLoginDetectedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly User $user,
        public readonly string $ipAddress,
        public readonly ?string $userAgent,
        public readonly string $loginAt,
    ) {}
}
