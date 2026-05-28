<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\District\DistrictRestoredEvent;

class LogDistrictRestored
{
    use LogsActivity;

    public function handle(DistrictRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        $this->logActivity(
            logName: 'district',
            subject: $event->district,
            causer: $event->causer,
            event: 'restored',
            message: "{$userName}, {$districtName} ilçesini geri aldı.",
        );
    }
}
