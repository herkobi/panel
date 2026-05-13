<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Events\Panel\Tools\Definitions\City\CityForceDeletedEvent;

class LogCityForceDeleted
{
    public function handle(CityForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        activity('city')
            ->performedOn($event->city)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$cityName} ilini kalıcı olarak sildi.");
    }
}
