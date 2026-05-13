<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityActivatedEvent;

class LogCityActivated
{
    public function handle(CityActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$cityName} ilini aktifleştirdi.");
    }
}
