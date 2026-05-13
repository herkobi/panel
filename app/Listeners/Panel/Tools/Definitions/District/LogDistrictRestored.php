<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictRestoredEvent;

class LogDistrictRestored
{
    public function handle(DistrictRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('restored')
            ->log("{$userName}, {$districtName} ilçesini geri aldı.");
    }
}
