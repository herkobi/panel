<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\City;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\City\CityForceDeletedEvent;

class LogCityForceDeleted
{
    use LogsActivity;

    public function handle(CityForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $cityName = $event->city->name;

        $this->logActivity(
            logName: 'city',
            subject: $event->city,
            causer: $event->causer,
            event: 'force_deleted',
            message: "{$userName}, {$cityName} ilini kalıcı olarak sildi.",
        );
    }
}
