<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Concerns\LogsActivity;
use App\Events\Panel\Members\MemberEmailChangeRequestedEvent;

class LogMemberEmailChangeRequested
{
    use LogsActivity;

    public function handle(MemberEmailChangeRequestedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'panel.member',
            subject: $event->user,
            causer: $event->causer,
            event: 'email_change_requested',
            message: "{$causerName}, {$memberLabel} üyesinin e-posta adresini {$event->user->email} → {$event->email} olarak değiştirmek için talep oluşturdu.",
            properties: [
                'user_id' => $event->user->id,
                'old_email' => $event->user->email,
                'new_email' => $event->email,
            ],
        );
    }
}
