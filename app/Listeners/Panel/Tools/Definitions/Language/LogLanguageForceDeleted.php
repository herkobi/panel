<?php

declare(strict_types=1);

namespace App\Listeners\Panel\Tools\Definitions\Language;

use App\Concerns\LogsActivity;
use App\Events\Panel\Tools\Definitions\Language\LanguageForceDeletedEvent;

class LogLanguageForceDeleted
{
    use LogsActivity;

    public function handle(LanguageForceDeletedEvent $event): void
    {
        $userName = $event->causer->name;
        $languageName = $event->language->name;

        $this->logActivity(
            logName: 'language',
            subject: $event->language,
            causer: $event->causer,
            event: 'force_deleted',
            message: "{$userName}, {$languageName} dilini kalıcı olarak sildi.",
        );
    }
}
