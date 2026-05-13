<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailChangeConfirmedEvent;

class LogMemberEmailChangeConfirmed
{
    public function handle(MemberEmailChangeConfirmedEvent $event): void
    {
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->newEmail;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->user)
            ->event('email_changed')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_email' => $event->oldEmail,
                'new_email' => $event->newEmail,
            ])
            ->log("{$memberLabel}, e-posta adresini {$event->oldEmail} → {$event->newEmail} olarak onayladı.");
    }
}
