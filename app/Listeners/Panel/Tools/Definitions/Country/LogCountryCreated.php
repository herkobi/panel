<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Country\CountryCreatedEvent;

class LogCountryCreated
{
    use LogsActivity;

    public function handle(CountryCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        $this->logActivity(
            logName: 'country',
            subject: $event->country,
            causer: $event->causer,
            event: 'created',
            message: "{$userName}, {$countryName} ülkesini oluşturdu.",
        );
    }
}
