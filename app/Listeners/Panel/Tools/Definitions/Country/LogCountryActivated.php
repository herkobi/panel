<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryActivatedEvent;

class LogCountryActivated
{
    public function handle(CountryActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$countryName} ülkesini aktifleştirdi.");
    }
}
