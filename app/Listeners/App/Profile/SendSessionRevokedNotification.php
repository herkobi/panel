<?php

declare(strict_types=1);

namespace App\Listeners\App\Profile;

use App\Events\App\Profile\SessionRevokedEvent;
use App\Notifications\App\Profile\SessionRevokedNotification;

class SendSessionRevokedNotification
{
    public function handle(SessionRevokedEvent $event): void
    {
        $event->updatedBy->notify(new SessionRevokedNotification($event->ipAddress));
    }
}
