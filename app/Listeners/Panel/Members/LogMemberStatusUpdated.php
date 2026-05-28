<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Concerns\LogsActivity;
use App\Events\Panel\Members\MemberStatusUpdatedEvent;

class LogMemberStatusUpdated
{
    use LogsActivity;

    public function handle(MemberStatusUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;
        $oldLabel = $event->oldStatus->value;
        $newLabel = $event->newStatus->value;

        $this->logActivity(
            logName: 'panel.member',
            subject: $event->user,
            causer: $event->causer,
            event: 'status_updated',
            message: "{$causerName}, {$memberLabel} üyesinin durumunu {$oldLabel} → {$newLabel} olarak değiştirdi.",
            properties: [
                'user_id' => $event->user->id,
                'old_status' => $event->oldStatus->value,
                'new_status' => $event->newStatus->value,
            ],
        );
    }
}
