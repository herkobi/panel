<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictDeactivatedEvent;

class LogDistrictDeactivated
{
    public function handle(DistrictDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('deactivated')
            ->log("{$userName}, {$districtName} ilçesini pasifleştirdi.");
    }
}
