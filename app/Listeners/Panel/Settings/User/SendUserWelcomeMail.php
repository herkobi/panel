<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserCreatedEvent;
use App\Notifications\Panel\Settings\User\UserWelcomeNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class SendUserWelcomeMail
{
    public function handle(UserCreatedEvent $event): void
    {
        $expireMinutes = (int) config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60);
        $token = Password::broker()->createToken($event->user);
        $welcomeUrl = URL::temporarySignedRoute(
            'panel.settings.users.welcome',
            now()->addMinutes($expireMinutes),
            [
                'user' => $event->user->id,
                'email' => $event->user->email,
                'token' => $token,
            ],
        );

        $event->user->notify(new UserWelcomeNotification(
            $welcomeUrl,
            $expireMinutes,
            ! $event->emailVerified,
        ));
    }
}
