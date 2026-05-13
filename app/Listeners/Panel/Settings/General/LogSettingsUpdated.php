<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Settings\General;

use App\Events\Panel\Settings\General\SettingsUpdatedEvent;

class LogSettingsUpdated
{
    public function handle(SettingsUpdatedEvent $event): void
    {
        $userName = $event->causer->name;

        activity('settings')
            ->causedBy($event->causer)
            ->event('updated')
            ->log("{$userName}, genel ayarları güncelledi.");
    }
}
