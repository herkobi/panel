<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberCreatedEvent;

class LogMemberCreated
{
    public function handle(MemberCreatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('created')
            ->withProperties([
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ])
            ->log("{$causerName}, {$memberLabel} üyesini oluşturdu.");
    }
}
