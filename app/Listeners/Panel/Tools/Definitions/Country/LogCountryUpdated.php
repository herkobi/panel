<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryUpdatedEvent;

class LogCountryUpdated
{
    public function handle(CountryUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('updated')
            ->log("{$userName}, {$countryName} ülkesini güncelledi.");
    }
}
