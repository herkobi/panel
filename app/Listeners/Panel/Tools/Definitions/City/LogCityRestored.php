<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityRestoredEvent;

class LogCityRestored
{
    public function handle(CityRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('restored')
            ->log("{$userName}, {$cityName} ilini geri aldı.");
    }
}
