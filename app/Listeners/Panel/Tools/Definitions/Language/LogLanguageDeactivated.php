<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageDeactivatedEvent;

class LogLanguageDeactivated
{
    public function handle(LanguageDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('deactivated')
            ->log("{$userName}, {$languageName} dilini pasifleştirdi.");
    }
}
