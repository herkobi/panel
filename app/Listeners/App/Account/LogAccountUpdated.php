<?php

declare(strict_types=1);

namespace App\Listeners\App\Account;

use App\Events\App\Account\AccountUpdatedEvent;

class LogAccountUpdated
{
    public function handle(AccountUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $accountName = $event->account->name ?? 'hesabı';

        activity('account')
            ->performedOn($event->account)
            ->causedBy($event->updatedBy)
            ->event('updated')
            ->log("{$userName}, {$accountName} hesap bilgilerini güncelledi.");
    }
}
