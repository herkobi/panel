<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityDeactivatedEvent;

class LogCityDeactivated
{
    public function handle(CityDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('deactivated')
            ->log("{$userName}, {$cityName} ilini pasifleştirdi.");
    }
}
