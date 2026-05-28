<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Concerns\LogsActivity;
use App\Events\Auth\PasswordResetNotificationRequestedEvent;

class LogPasswordResetNotificationRequested
{
    use LogsActivity;

    public function handle(PasswordResetNotificationRequestedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'auth',
            subject: $event->user,
            causer: $event->user,
            event: 'password_reset_requested',
            message: "{$userLabel} için şifre sıfırlama bildirimi gönderildi.",
        );
    }
}
