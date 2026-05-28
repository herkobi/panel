<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyDeletedEvent;

class LogCurrencyDeleted
{
    use LogsActivity;

    public function handle(CurrencyDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        $this->logActivity(
            logName: 'currency',
            subject: $event->currency,
            causer: $event->causer,
            event: 'deleted',
            message: "{$userName}, {$code} para birimini sildi.",
        );
    }
}
