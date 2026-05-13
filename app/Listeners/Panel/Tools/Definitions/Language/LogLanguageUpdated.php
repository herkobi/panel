<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageUpdatedEvent;

class LogLanguageUpdated
{
    public function handle(LanguageUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('updated')
            ->log("{$userName}, {$languageName} dilini güncelledi.");
    }
}
