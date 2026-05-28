<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyForceDeletedEvent;

class LogCurrencyForceDeleted
{
    use LogsActivity;

    public function handle(CurrencyForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        $this->logActivity(
            logName: 'currency',
            subject: $event->currency,
            causer: $event->causer,
            event: 'force_deleted',
            message: "{$userName}, {$code} para birimini kalıcı olarak sildi.",
        );
    }
}
