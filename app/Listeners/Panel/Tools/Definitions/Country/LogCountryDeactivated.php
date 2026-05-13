<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryDeactivatedEvent;

class LogCountryDeactivated
{
    public function handle(CountryDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('deactivated')
            ->log("{$userName}, {$countryName} ülkesini pasifleştirdi.");
    }
}
