<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Events\Panel\Tools\Definitions\Currency\CurrencyDeletedEvent;

class LogCurrencyDeleted
{
    public function handle(CurrencyDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        activity('currency')
            ->performedOn($event->currency)
            ->causedBy($event->causer)
            ->event('deleted')
            ->log("{$userName}, {$code} para birimini sildi.");
    }
}
