<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Country;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Country\CountryForceDeletedEvent;

class LogCountryForceDeleted
{
    use LogsActivity;

    public function handle(CountryForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $countryName = $event->country->name;

        $this->logActivity(
            logName: 'country',
            subject: $event->country,
            causer: $event->causer,
            event: 'force_deleted',
            message: "{$userName}, {$countryName} ülkesini kalıcı olarak sildi.",
        );
    }
}
