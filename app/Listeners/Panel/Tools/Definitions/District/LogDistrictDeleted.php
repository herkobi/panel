<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictDeletedEvent;

class LogDistrictDeleted
{
    use LogsActivity;

    public function handle(DistrictDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'deleted',
            message: "{$userName}, {$districtName} ilçesini sildi.",
        );
    }
}
