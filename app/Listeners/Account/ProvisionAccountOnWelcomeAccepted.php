<?php

declare(strict_types=1);

namespace App\Listeners\Account;

use App\Events\Panel\Members\MemberWelcomeAcceptedEvent;
use App\Services\Account\AccountProvisioner;

class ProvisionAccountOnWelcomeAccepted
{
    public function __construct(
        private readonly AccountProvisioner $provisioner,
    ) {}

    public function handle(MemberWelcomeAcceptedEvent $event): void
    {
        $this->provisioner->ensureForUser($event->user);
    }
}
