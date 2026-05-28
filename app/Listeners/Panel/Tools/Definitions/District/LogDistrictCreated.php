<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictCreatedEvent;

class LogDistrictCreated
{
    use LogsActivity;

    public function handle(DistrictCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'created',
            message: "{$userName}, {$districtName} ilçesini oluşturdu.",
        );
    }
}
