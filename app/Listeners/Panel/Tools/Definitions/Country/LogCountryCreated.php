<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryCreatedEvent;

class LogCountryCreated
{
    public function handle(CountryCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('created')
            ->log("{$userName}, {$countryName} ülkesini oluşturdu.");
    }
}
