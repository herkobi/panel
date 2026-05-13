<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserStatusUpdatedEvent;
use App\Jobs\Panel\Settings\User\SendUserStatusUpdatedMail as SendUserStatusUpdatedMailJob;

class SendUserStatusUpdatedMail
{
    public function handle(UserStatusUpdatedEvent $event): void
    {
        SendUserStatusUpdatedMailJob::dispatch($event->user, $event->newStatus);
    }
}
