<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictDeletedEvent;

class LogDistrictDeleted
{
    public function handle(DistrictDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('deleted')
            ->log("{$userName}, {$districtName} ilçesini sildi.");
    }
}
