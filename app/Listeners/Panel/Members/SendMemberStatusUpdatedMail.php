<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberStatusUpdatedEvent;
use App\Notifications\Panel\Members\MemberStatusUpdatedNotification;

class SendMemberStatusUpdatedMail
{
    public function handle(MemberStatusUpdatedEvent $event): void
    {
        $event->user->notify(new MemberStatusUpdatedNotification($event->newStatus));
    }
}
