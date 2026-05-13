<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Events\Panel\Tools\Definitions\Currency\CurrencyCreatedEvent;

class LogCurrencyCreated
{
    public function handle(CurrencyCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        activity('currency')
            ->performedOn($event->currency)
            ->causedBy($event->causer)
            ->event('created')
            ->log("{$userName}, {$code} para birimini oluşturdu.");
    }
}
