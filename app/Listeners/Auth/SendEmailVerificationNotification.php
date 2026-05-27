<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\EmailVerificationNotificationRequestedEvent;
use App\Notifications\Auth\VerifyEmailNotification;

class SendEmailVerificationNotification
{
    public function handle(EmailVerificationNotificationRequestedEvent $event): void
    {
        $event->user->notify(new VerifyEmailNotification);
    }
}
