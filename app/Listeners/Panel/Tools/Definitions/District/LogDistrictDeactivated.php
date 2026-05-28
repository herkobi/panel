<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictDeactivatedEvent;

class LogDistrictDeactivated
{
    use LogsActivity;

    public function handle(DistrictDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$districtName} ilçesini pasifleştirdi.",
        );
    }
}
