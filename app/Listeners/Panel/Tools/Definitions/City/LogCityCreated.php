<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\City\CityCreatedEvent;

class LogCityCreated
{
    use LogsActivity;

    public function handle(CityCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        $this->logActivity(
            logName: 'city',
            subject: $event->city,
            causer: $event->causer,
            event: 'created',
            message: "{$userName}, {$cityName} ilini oluşturdu.",
        );
    }
}
