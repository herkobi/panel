<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\District;

use App\Events\Panel\Tools\Definitions\District\DistrictForceDeletedEvent;

class LogDistrictForceDeleted
{
    public function handle(DistrictForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $districtName = $event->district->name;

        activity('district')
            ->performedOn($event->district)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$districtName} ilçesini kalıcı olarak sildi.");
    }
}
