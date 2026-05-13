<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class LogPasswordResetCompleted
{
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if (! $user instanceof User) {
            return;
        }

        $userLabel = $user->name !== '' ? $user->name : $user->email;

        activity('auth')
            ->causedBy($user)
            ->performedOn($user)
            ->event('password_reset_completed')
            ->log("{$userLabel}, şifre sıfırlamayı tamamladı.");
    }
}
