<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailChangeRequestedEvent;
use App\Notifications\Panel\Members\MemberEmailChangeRequestedNotification;
use Illuminate\Support\Facades\URL;

class SendMemberEmailChangeRequestedMail
{
    public function handle(MemberEmailChangeRequestedEvent $event): void
    {
        $confirmationUrl = URL::temporarySignedRoute(
            'panel.members.email.confirm',
            now()->addDay(),
            [
                'user' => $event->user->id,
                'email' => $event->email,
            ],
        );

        $event->user->notify(new MemberEmailChangeRequestedNotification(
            $event->email,
            $confirmationUrl,
        ));
    }
}
