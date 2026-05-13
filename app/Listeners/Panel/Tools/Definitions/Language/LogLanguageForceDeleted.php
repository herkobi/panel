<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Events\Panel\Tools\Definitions\Language\LanguageForceDeletedEvent;

class LogLanguageForceDeleted
{
    public function handle(LanguageForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        activity('language')
            ->performedOn($event->language)
            ->causedBy($event->causer)
            ->event('force_deleted')
            ->log("{$userName}, {$languageName} dilini kalıcı olarak sildi.");
    }
}
