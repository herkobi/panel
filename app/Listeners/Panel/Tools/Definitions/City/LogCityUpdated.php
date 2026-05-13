<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityUpdatedEvent;

class LogCityUpdated
{
    public function handle(CityUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('updated')
            ->log("{$userName}, {$cityName} ilini güncelledi.");
    }
}
