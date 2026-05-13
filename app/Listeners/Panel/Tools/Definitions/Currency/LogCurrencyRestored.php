<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Events\Panel\Tools\Definitions\Currency\CurrencyRestoredEvent;

class LogCurrencyRestored
{
    public function handle(CurrencyRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        activity('currency')
            ->performedOn($event->currency)
            ->causedBy($event->causer)
            ->event('restored')
            ->log("{$userName}, {$code} para birimini geri aldı.");
    }
}
