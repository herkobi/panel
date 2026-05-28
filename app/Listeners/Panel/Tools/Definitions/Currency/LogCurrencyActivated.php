<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Currency\CurrencyActivatedEvent;

class LogCurrencyActivated
{
    use LogsActivity;

    public function handle(CurrencyActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        $this->logActivity(
            logName: 'currency',
            subject: $event->currency,
            causer: $event->causer,
            event: 'activated',
            message: "{$userName}, {$code} para birimini aktifleştirdi.",
        );
    }
}
