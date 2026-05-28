<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyDeactivatedEvent;

class LogCurrencyDeactivated
{
    use LogsActivity;

    public function handle(CurrencyDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        $this->logActivity(
            logName: 'currency',
            subject: $event->currency,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$code} para birimini pasifleştirdi.",
        );
    }
}
