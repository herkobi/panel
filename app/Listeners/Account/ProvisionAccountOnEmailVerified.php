<?php

declare(strict_types=1);

namespace App\Listeners\Account;

use App\Models\User;
use App\Services\Account\AccountProvisioner;
use Illuminate\Auth\Events\Verified;

class ProvisionAccountOnEmailVerified
{
    public function __construct(
        private readonly AccountProvisioner $provisioner,
    ) {}

    public function handle(Verified $event): void
    {
        // Self-servis e-posta doğrulaması (Fortify). Provisioner zaten member-only.
        if (! $event->user instanceof User) {
            return;
        }

        $this->provisioner->ensureForUser($event->user);
    }
}
