<?php

namespace App\Listeners\Admin\Tools\Language;

use App\Events\Admin\Tools\Language\Create as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\AuthUser;
use App\Traits\LogActivity;

class Create
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
            'language.created',
            $event->createdBy,
            $event->language,
            [
                'language_title' => $event->language->title,
            ]
        );

        Activity::create([
            'message' => 'language.created',
            'log' => $this->logActivity(
                ' user created new language',
                $event->createdBy,
                $event->language,
                [
                    'language_title' => $event->language->title,
                ]
            ),
        ]);
    }
}
