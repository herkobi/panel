<?php

namespace App\Listeners\Admin\Tools\Language;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Tools\Language\Delete as Event;
use App\Traits\LogActivity;

class Delete
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
            'language.deleted',
            $event->deletedBy,
            $event->language,
            [
                'language_title' => $event->language->title,
            ]
        );

        Activity::create([
            'message' => 'language.deleted',
            'log' => $this->logActivity(
                ' user deleted language ',
                $event->deletedBy,
                $event->language,
                [
                    'language_title' => $event->language->title
                ]
            ),
        ]);
    }
}
