<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityDeletedEvent;

class LogCityDeleted
{
    public function handle(CityDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('deleted')
            ->log("{$userName}, {$cityName} ilini sildi.");
    }
}
