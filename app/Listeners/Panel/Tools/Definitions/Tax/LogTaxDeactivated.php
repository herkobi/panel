<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Tax;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Tax\TaxDeactivatedEvent;

class LogTaxDeactivated
{
    use LogsActivity;

    public function handle(TaxDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $taxName = $event->tax->name;

        $this->logActivity(
            logName: 'tax_rate',
            subject: $event->tax,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$taxName} vergi oranını pasifleştirdi.",
        );
    }
}
