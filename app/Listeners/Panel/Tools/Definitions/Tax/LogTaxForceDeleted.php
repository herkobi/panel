<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Tax;

use App\Events\Panel\Tools\Definitions\Tax\TaxForceDeletedEvent;

class LogTaxForceDeleted
{
    public function handle(TaxForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $taxName = $event->tax->name;

        activity('tax_rate')
            ->performedOn($event->tax)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$taxName} vergi oranını kalıcı olarak sildi.");
    }
}
