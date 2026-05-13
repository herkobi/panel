<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberWelcomeAcceptedEvent;

class LogMemberWelcomeAccepted
{
    public function handle(MemberWelcomeAcceptedEvent $event): void
    {
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->user)
            ->event('welcome_accepted')
            ->withProperties([
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ])
            ->log("{$memberLabel}, hoş geldin bağlantısını açtı.");
    }
}
