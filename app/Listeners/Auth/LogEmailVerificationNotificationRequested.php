<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\EmailVerificationNotificationRequestedEvent;

class LogEmailVerificationNotificationRequested
{
    public function handle(EmailVerificationNotificationRequestedEvent $event): void
    {
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('email_verification_requested')
            ->log("{$userLabel} için e-posta doğrulama bildirimi gönderildi.");
    }
}
