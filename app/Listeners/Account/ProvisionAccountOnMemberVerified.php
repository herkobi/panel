<?php

declare(strict_types=1);

namespace App\Listeners\Account;

use App\Events\Panel\Members\MemberEmailVerifiedEvent;
use App\Services\Account\AccountProvisioner;

class ProvisionAccountOnMemberVerified
{
    public function __construct(
        private readonly AccountProvisioner $provisioner,
    ) {}

    public function handle(MemberEmailVerifiedEvent $event): void
    {
        $this->provisioner->ensureForUser($event->user);
    }
}
