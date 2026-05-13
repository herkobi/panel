<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;

class LogUserVerified
{
    public function handle(Verified $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $userLabel = $user->name !== '' ? $user->name : $user->email;

        activity('auth')
            ->causedBy($user)
            ->performedOn($user)
            ->event('verified')
            ->log("{$userLabel}, e-posta adresini doğruladı.");
    }
}
