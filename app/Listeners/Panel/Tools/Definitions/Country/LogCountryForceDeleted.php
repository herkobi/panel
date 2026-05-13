<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Events\Panel\Tools\Definitions\Country\CountryForceDeletedEvent;

class LogCountryForceDeleted
{
    public function handle(CountryForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        activity('country')
            ->performedOn($event->country)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$countryName} ülkesini kalıcı olarak sildi.");
    }
}
