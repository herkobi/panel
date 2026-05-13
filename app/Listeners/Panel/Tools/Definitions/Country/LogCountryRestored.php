<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryRestoredEvent;

class LogCountryRestored
{
    public function handle(CountryRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('restored')
            ->log("{$userName}, {$countryName} ülkesini geri aldı.");
    }
}
