<?php

declare(strict_types=1);

namespace App\Listeners\Account;

use App\Events\Panel\Members\MemberCreatedEvent;
use App\Services\Account\AccountProvisioner;

class ProvisionAccountOnMemberCreated
{
    public function __construct(
        private readonly AccountProvisioner $provisioner,
    ) {}

    public function handle(MemberCreatedEvent $event): void
    {
        // Account yalnızca e-posta doğrulanmışsa oluşur; admin onaylı üye eklediğinde de bu olur.
        if (! $event->emailVerified) {
            return;
        }

        $this->provisioner->ensureForUser($event->user);
    }
}
