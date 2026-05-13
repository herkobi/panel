<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictCreatedEvent;

class LogDistrictCreated
{
    public function handle(DistrictCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('created')
            ->log("{$userName}, {$districtName} ilçesini oluşturdu.");
    }
}
