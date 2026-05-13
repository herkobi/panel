<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageRestoredEvent;

class LogLanguageRestored
{
    public function handle(LanguageRestoredEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('restored')
            ->log("{$userName}, {$languageName} dilini geri aldı.");
    }
}
