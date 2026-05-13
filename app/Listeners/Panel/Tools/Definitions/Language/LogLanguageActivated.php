<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageActivatedEvent;

class LogLanguageActivated
{
    public function handle(LanguageActivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('activated')
            ->log("{$userName}, {$languageName} dilini aktifleştirdi.");
    }
}
