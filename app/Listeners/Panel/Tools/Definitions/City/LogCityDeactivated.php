<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\City\CityDeactivatedEvent;

class LogCityDeactivated
{
    use LogsActivity;

    public function handle(CityDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        $this->logActivity(
            logName: 'city',
            subject: $event->city,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$cityName} ilini pasifleştirdi.",
        );
    }
}
