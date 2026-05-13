<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Tax;

use App\Events\Panel\Tools\Definitions\Tax\TaxActivatedEvent;

class LogTaxActivated
{
    public function handle(TaxActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $taxName = $event->tax->name;

        activity('tax_rate')
            ->performedOn($event->tax)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$taxName} vergi oranını aktifleştirdi.");
    }
}
