<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\User;
use App\Notifications\Auth\PasswordResetCompletedNotification;
use Illuminate\Auth\Events\PasswordReset;

class SendPasswordResetCompletedNotification
{
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if (! $user instanceof User) {
            return;
        }

        $user->notify(new PasswordResetCompletedNotification);
    }
}
