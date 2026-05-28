<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Concerns\LogsActivity;
use App\Events\Panel\Members\MemberEmailChangeConfirmedEvent;

class LogMemberEmailChangeConfirmed
{
    use LogsActivity;

    public function handle(MemberEmailChangeConfirmedEvent $event): void
    {
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->newEmail;

        $this->logActivity(
            logName: 'panel.member',
            subject: $event->user,
            causer: $event->user,
            event: 'email_changed',
            message: "{$memberLabel}, e-posta adresini {$event->oldEmail} → {$event->newEmail} olarak onayladı.",
            properties: [
                'user_id' => $event->user->id,
                'old_email' => $event->oldEmail,
                'new_email' => $event->newEmail,
            ],
        );
    }
}
