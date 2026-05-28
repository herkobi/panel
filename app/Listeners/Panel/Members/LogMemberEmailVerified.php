<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Concerns\LogsActivity;
use App\Events\Panel\Members\MemberEmailVerifiedEvent;

class LogMemberEmailVerified
{
    use LogsActivity;

    public function handle(MemberEmailVerifiedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        $this->logActivity(
            logName: 'panel.member',
            subject: $event->user,
            causer: $event->causer,
            event: 'email_verified',
            message: "{$causerName}, {$memberLabel} üyesinin e-posta adresini onayladı.",
            properties: ['user_id' => $event->user->id],
        );
    }
}
