<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\NewDeviceLoginDetectedEvent;
use App\Notifications\Auth\NewDeviceLoginNotification;

class SendNewDeviceLoginNotification
{
    public function handle(NewDeviceLoginDetectedEvent $event): void
    {
        $notification = new NewDeviceLoginNotification(
            ipAddress: $event->ipAddress,
            userAgent: $event->userAgent,
            loginAt: $event->loginAt,
        );

        $event->user->notify($notification);
    }
}
