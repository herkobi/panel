<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Language\LanguageCreatedEvent;

class LogLanguageCreated
{
    use LogsActivity;

    public function handle(LanguageCreatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        $this->logActivity(
            logName: 'language',
            subject: $event->language,
            causer: $event->causer,
            event: 'created',
            message: "{$userName}, {$languageName} dilini oluşturdu.",
        );
    }
}
