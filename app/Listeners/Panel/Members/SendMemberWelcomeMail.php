<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberCreatedEvent;
use App\Notifications\Panel\Members\MemberWelcomeNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class SendMemberWelcomeMail
{
    public function handle(MemberCreatedEvent $event): void
    {
        $expireMinutes = (int) config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60);
        $token = Password::broker()->createToken($event->user);
        $welcomeUrl = URL::temporarySignedRoute(
            'panel.members.welcome',
            now()->addMinutes($expireMinutes),
            [
                'user' => $event->user->id,
                'email' => $event->user->email,
                'token' => $token,
            ],
        );

        $event->user->notify(new MemberWelcomeNotification(
            $welcomeUrl,
            $expireMinutes,
            ! $event->emailVerified,
        ));
    }
}
