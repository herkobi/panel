<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailChangeRequestedEvent;

class LogMemberEmailChangeRequested
{
    public function handle(MemberEmailChangeRequestedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('email_change_requested')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_email' => $event->user->email,
                'new_email' => $event->email,
            ])
            ->log("{$causerName}, {$memberLabel} üyesinin e-posta adresini {$event->user->email} → {$event->email} olarak değiştirmek için talep oluşturdu.");
    }
}
