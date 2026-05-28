<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Language\LanguageDeactivatedEvent;

class LogLanguageDeactivated
{
    use LogsActivity;

    public function handle(LanguageDeactivatedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        $this->logActivity(
            logName: 'language',
            subject: $event->language,
            causer: $event->causer,
            event: 'deactivated',
            message: "{$userName}, {$languageName} dilini pasifleştirdi.",
        );
    }
}
