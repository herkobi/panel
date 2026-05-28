<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Concerns\LogsActivity;
use App\Events\Auth\EmailVerificationNotificationRequestedEvent;

class LogEmailVerificationNotificationRequested
{
    use LogsActivity;

    public function handle(EmailVerificationNotificationRequestedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'auth',
            subject: $event->user,
            causer: $event->user,
            event: 'email_verification_requested',
            message: "{$userLabel} için e-posta doğrulama bildirimi gönderildi.",
        );
    }
}
