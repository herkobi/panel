<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\EmailVerificationNotificationRequestedEvent;
use App\Jobs\Auth\SendEmailVerificationMail;

class SendEmailVerificationNotification
{
    public function handle(EmailVerificationNotificationRequestedEvent $event): void
    {
        SendEmailVerificationMail::dispatch($event->user);
    }
}
