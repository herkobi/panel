<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\PasswordResetNotificationRequestedEvent;
use App\Jobs\Auth\SendPasswordResetMail;

class SendPasswordResetNotification
{
    public function handle(PasswordResetNotificationRequestedEvent $event): void
    {
        SendPasswordResetMail::dispatch($event->user, $event->token);
    }
}
