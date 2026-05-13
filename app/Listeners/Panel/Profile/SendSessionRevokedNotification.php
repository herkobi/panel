<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\SessionRevokedEvent;
use App\Notifications\Panel\Profile\SessionRevokedNotification;

class SendSessionRevokedNotification
{
    public function handle(SessionRevokedEvent $event): void
    {
        $event->updatedBy->notify(new SessionRevokedNotification($event->ipAddress));
    }
}
