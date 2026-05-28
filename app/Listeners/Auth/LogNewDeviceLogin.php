<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Concerns\LogsActivity;
use App\Events\Auth\NewDeviceLoginDetectedEvent;

class LogNewDeviceLogin
{
    use LogsActivity;

    public function handle(NewDeviceLoginDetectedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'auth',
            subject: $event->user,
            causer: $event->user,
            event: 'new_device_login',
            message: "{$userLabel}, yeni bir cihazdan giriş yaptı ({$event->ipAddress}).",
            properties: [
                'ip_address' => $event->ipAddress,
                'user_agent' => $event->userAgent,
                'login_at' => $event->loginAt,
            ],
        );
    }
}
