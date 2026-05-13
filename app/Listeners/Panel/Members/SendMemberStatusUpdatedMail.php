<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberStatusUpdatedEvent;
use App\Jobs\Panel\Members\SendMemberStatusUpdatedMail as SendMemberStatusUpdatedMailJob;

class SendMemberStatusUpdatedMail
{
    public function handle(MemberStatusUpdatedEvent $event): void
    {
        SendMemberStatusUpdatedMailJob::dispatch($event->user, $event->newStatus);
    }
}
