<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictActivatedEvent;

class LogDistrictActivated
{
    public function handle(DistrictActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$districtName} ilçesini aktifleştirdi.");
    }
}
