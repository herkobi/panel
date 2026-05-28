<?php

declare(strict_types=1);

namespace App\Listeners\App\Account;

use App\Concerns\LogsActivity;
use App\Events\App\Account\AccountUpdatedEvent;

class LogAccountUpdated
{
    use LogsActivity;

    public function handle(AccountUpdatedEvent $event): void
    {
        $userName = $event->updatedBy->name;
        $accountName = $event->account->name ?? 'hesabı';

        $this->logActivity(
            logName: 'account',
            subject: $event->account,
            causer: $event->updatedBy,
            event: 'updated',
            message: "{$userName}, {$accountName} hesap bilgilerini güncelledi.",
        );
    }
}
