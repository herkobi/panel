<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryDeletedEvent;

class LogCountryDeleted
{
    public function handle(CountryDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('deleted')
            ->log("{$userName}, {$countryName} ülkesini sildi.");
    }
}
