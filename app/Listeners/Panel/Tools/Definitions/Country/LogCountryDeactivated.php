<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Country\CountryDeactivatedEvent;

class LogCountryDeactivated
{
    use LogsActivity;

    public function handle(CountryDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        $this->logActivity(
            logName: 'country',
            subject: $event->country,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$countryName} ülkesini pasifleştirdi.",
        );
    }
}
