<?php

namespace App\Listeners\Admin\Tools\Country;

use App\Events\Admin\Tools\Country\Create as Event;
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
            'country.created',
            $event->createdBy,
            $event->country,
            [
                'country_title' => $event->country->title,
            ]
        );

        Activity::create([
            'message' => 'country.created',
            'log' => $this->logActivity(
                ' user created new country',
                $event->createdBy,
                $event->country,
                [
                    'country_title' => $event->country->title,
                ]
            ),
        ]);
    }
}
