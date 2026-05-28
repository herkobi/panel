<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Concerns\LogsActivity;
use App\Events\Panel\Members\MemberCreatedEvent;

class LogMemberCreated
{
    use LogsActivity;

    public function handle(MemberCreatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'panel.member',
            subject: $event->user,
            causer: $event->causer,
            event: 'created',
            message: "{$causerName}, {$memberLabel} üyesini oluşturdu.",
            properties: [
                'user_id' => $event->user->id,
                'email_verified' => $event->emailVerified,
            ],
        );
    }
}
