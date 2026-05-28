<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Country\CountryActivatedEvent;

class LogCountryActivated
{
    use LogsActivity;

    public function handle(CountryActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        $this->logActivity(
            logName: 'country',
            subject: $event->country,
            causer: $event->causer,
            event: 'activated',
            message: "{$userName}, {$countryName} ülkesini aktifleştirdi.",
        );
    }
}
