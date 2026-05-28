<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Language\LanguageUpdatedEvent;

class LogLanguageUpdated
{
    use LogsActivity;

    public function handle(LanguageUpdatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        $this->logActivity(
            logName: 'language',
            subject: $event->language,
            causer: $event->causer,
            event: 'updated',
            message: "{$userName}, {$languageName} dilini güncelledi.",
        );
    }
}
