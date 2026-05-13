<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageCreatedEvent;

class LogLanguageCreated
{
    public function handle(LanguageCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('created')
            ->log("{$userName}, {$languageName} dilini oluşturdu.");
    }
}
