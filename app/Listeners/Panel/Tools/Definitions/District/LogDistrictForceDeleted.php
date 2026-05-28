<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictForceDeletedEvent;

class LogDistrictForceDeleted
{
    use LogsActivity;

    public function handle(DistrictForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'force_deleted',
            message: "{$userName}, {$districtName} ilçesini kalıcı olarak sildi.",
        );
    }
}
