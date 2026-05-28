<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Country\CountryUpdatedEvent;

class LogCountryUpdated
{
    use LogsActivity;

    public function handle(CountryUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        $this->logActivity(
            logName: 'country',
            subject: $event->country,
            causer: $event->causer,
            event: 'updated',
            message: "{$userName}, {$countryName} ülkesini güncelledi.",
        );
    }
}
