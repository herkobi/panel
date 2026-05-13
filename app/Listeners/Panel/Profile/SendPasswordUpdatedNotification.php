<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Profile;

use App\Events\Panel\Profile\PasswordUpdatedEvent;
use App\Notifications\Panel\Profile\PasswordUpdatedNotification;

class SendPasswordUpdatedNotification
{
    public function handle(PasswordUpdatedEvent $event): void
    {
        $event->updatedBy->notify(new PasswordUpdatedNotification);
    }
}
