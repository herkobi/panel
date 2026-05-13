<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\User;

use App\Events\Panel\Settings\User\UserEmailVerifiedEvent;
use App\Jobs\Panel\Settings\User\SendUserEmailVerifiedMail as SendUserEmailVerifiedMailJob;

class SendUserEmailVerifiedMail
{
    public function handle(UserEmailVerifiedEvent $event): void
    {
        SendUserEmailVerifiedMailJob::dispatch($event->user);
    }
}
