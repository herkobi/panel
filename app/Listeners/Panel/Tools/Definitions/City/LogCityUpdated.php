<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\City\CityUpdatedEvent;

class LogCityUpdated
{
    use LogsActivity;

    public function handle(CityUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        $this->logActivity(
            logName: 'city',
            subject: $event->city,
            causer: $event->causer,
            event: 'updated',
            message: "{$userName}, {$cityName} ilini güncelledi.",
        );
    }
}
