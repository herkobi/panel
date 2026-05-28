<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyUpdatedEvent;

class LogCurrencyUpdated
{
    use LogsActivity;

    public function handle(CurrencyUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        $this->logActivity(
            logName: 'currency',
            subject: $event->currency,
            causer: $event->causer,
            event: 'updated',
            message: "{$userName}, {$code} para birimini güncelledi.",
        );
    }
}
