<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictActivatedEvent;

class LogDistrictActivated
{
    use LogsActivity;

    public function handle(DistrictActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'activated',
            message: "{$userName}, {$districtName} ilçesini aktifleştirdi.",
        );
    }
}
