<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Concerns\LogsActivity;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class LogPasswordResetCompleted
{
    use LogsActivity;

    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if (! $user instanceof User) {
            return;
        }

        $userLabel = $user->name !== '' ? $user->name : $user->email;

        $this->logActivity(
            logName: 'auth',
            subject: $user,
            causer: $user,
            event: 'password_reset_completed',
            message: "{$userLabel}, şifre sıfırlamayı tamamladı.",
        );
    }
}
