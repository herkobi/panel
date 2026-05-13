<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageDeletedEvent;

class LogLanguageDeleted
{
    public function handle(LanguageDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('deleted')
            ->log("{$userName}, {$languageName} dilini sildi.");
    }
}
