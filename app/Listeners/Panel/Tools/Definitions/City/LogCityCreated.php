<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityCreatedEvent;

class LogCityCreated
{
    public function handle(CityCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('created')
            ->log("{$userName}, {$cityName} ilini oluşturdu.");
    }
}
