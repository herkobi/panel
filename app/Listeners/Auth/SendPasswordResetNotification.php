<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\PasswordResetNotificationRequestedEvent;
use App\Notifications\Auth\ResetPasswordNotification;

class SendPasswordResetNotification
{
    public function handle(PasswordResetNotificationRequestedEvent $event): void
    {
        $event->user->notify(new ResetPasswordNotification($event->token));
    }
}
