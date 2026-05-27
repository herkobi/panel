<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailVerifiedEvent;
use App\Notifications\Panel\Members\MemberEmailVerifiedNotification;

class SendMemberEmailVerifiedMail
{
    public function handle(MemberEmailVerifiedEvent $event): void
    {
        $event->user->notify(new MemberEmailVerifiedNotification);
    }
}
