<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailVerifiedEvent;
use App\Jobs\Panel\Members\SendMemberEmailVerifiedMail as SendMemberEmailVerifiedMailJob;

class SendMemberEmailVerifiedMail
{
    public function handle(MemberEmailVerifiedEvent $event): void
    {
        SendMemberEmailVerifiedMailJob::dispatch($event->user);
    }
}
