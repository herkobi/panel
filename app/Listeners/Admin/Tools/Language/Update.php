<?php

namespace App\Listeners\Admin\Tools\Language;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Tools\Language\Update as Event;
use App\Traits\LogActivity;

class Update
{
    use LogActivity;

    protected $loggingService;
    protected $activity;

    public function __construct(LoggingService $loggingService, Activity $activity)
    {
        $this->loggingService = $loggingService;
        $this->activity = $activity;
    }

    public function handle(Event $event)
    {
        $this->loggingService->logUserAction(
            'language.updated',
            $event->changedBy,
            $event->language,
            [
                'new_language' => $event->newLanguage,
                'old_language' => $event->oldLanguage
            ]
        );

        Activity::create([
            'message' => 'language.updated',
            'log' => $this->logActivity(
                'user updated language of',
                $event->changedBy,
                $event->language,
                [
                    'old_language' => $event->oldLanguage,
                    'new_language' => $event->newLanguage
                ]
            ),
        ]);
    }
}
