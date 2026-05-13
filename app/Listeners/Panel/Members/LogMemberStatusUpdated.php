<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberStatusUpdatedEvent;

class LogMemberStatusUpdated
{
    public function handle(MemberStatusUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;
        $oldLabel = $event->oldStatus->value;
        $newLabel = $event->newStatus->value;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('status_updated')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_status' => $event->oldStatus->value,
                'new_status' => $event->newStatus->value,
            ])
            ->log("{$causerName}, {$memberLabel} üyesinin durumunu {$oldLabel} → {$newLabel} olarak değiştirdi.");
    }
}
