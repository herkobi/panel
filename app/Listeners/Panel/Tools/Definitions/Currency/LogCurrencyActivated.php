<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Events\Panel\Tools\Definitions\Currency\CurrencyActivatedEvent;

class LogCurrencyActivated
{
    public function handle(CurrencyActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        activity('currency')
            ->performedOn($event->currency)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$code} para birimini aktifleştirdi.");
    }
}
