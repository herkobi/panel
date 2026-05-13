<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\NewDeviceLoginDetectedEvent;

class LogNewDeviceLogin
{
    public function handle(NewDeviceLoginDetectedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('new_device_login')
            ->withProperties([
                'ip_address' => $event->ipAddress,
                'user_agent' => $event->userAgent,
                'login_at' => $event->loginAt,
            ])
            ->log("{$userLabel}, yeni bir cihazdan giriş yaptı ({$event->ipAddress}).");
    }
}
