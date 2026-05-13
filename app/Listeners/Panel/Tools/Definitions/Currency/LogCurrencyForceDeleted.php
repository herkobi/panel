<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Currency;

use App\Events\Panel\Tools\Definitions\Currency\CurrencyForceDeletedEvent;

class LogCurrencyForceDeleted
{
    public function handle(CurrencyForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $code = $event->currency->code;

        activity('currency')
            ->performedOn($event->currency)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$code} para birimini kalıcı olarak sildi.");
    }
}
