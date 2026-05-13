<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Members;

use App\Events\Panel\Members\MemberEmailVerifiedEvent;

class LogMemberEmailVerified
{
    public function handle(MemberEmailVerifiedEvent $event): void
    {
        $causerName = $event->causer->name;
        $memberLabel = $event->user->name !== '' ? $event->user->name : $event->user->email;

        activity('panel.member')
            ->performedOn($event->user)
            ->causedBy($event->causer)
            ->event('email_verified')
            ->withProperties(['user_id' => $event->user->id])
            ->log("{$causerName}, {$memberLabel} üyesinin e-posta adresini onayladı.");
    }
}
