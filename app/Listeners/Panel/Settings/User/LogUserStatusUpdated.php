<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserStatusUpdatedEvent;

class LogUserStatusUpdated
{
    public function handle(UserStatusUpdatedEvent $event): void
    {
        $causerName = $event->causer->name;
        $userLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('settings.user')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('status_updated')
            ->withProperties([
                'user_id' => $event->user->id,
                'old_status' => $event->oldStatus->value,
                'new_status' => $event->newStatus->value,
            ])
            ->log("{$causerName}, {$userLabel} panel kullanıcısının durumunu {$event->oldStatus->value} → {$event->newStatus->value} olarak değiştirdi.");
    }
}
