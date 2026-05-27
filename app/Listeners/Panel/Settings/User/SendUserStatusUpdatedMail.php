<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserStatusUpdatedEvent;
use App\Notifications\Panel\Settings\User\UserStatusUpdatedNotification;

class SendUserStatusUpdatedMail
{
    public function handle(UserStatusUpdatedEvent $event): void
    {
        $event->user->notify(new UserStatusUpdatedNotification($event->newStatus));
    }
}
