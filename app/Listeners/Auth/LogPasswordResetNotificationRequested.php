<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\PasswordResetNotificationRequestedEvent;

class LogPasswordResetNotificationRequested
{
    public function handle(PasswordResetNotificationRequestedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('password_reset_requested')
            ->log("{$userLabel} için şifre sıfırlama bildirimi gönderildi.");
    }
}
