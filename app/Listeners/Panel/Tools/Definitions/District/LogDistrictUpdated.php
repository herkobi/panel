<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictUpdatedEvent;

class LogDistrictUpdated
{
    public function handle(DistrictUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('updated')
            ->log("{$userName}, {$districtName} ilçesini güncelledi.");
    }
}
