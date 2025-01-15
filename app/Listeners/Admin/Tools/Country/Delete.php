<?php

namespace App\Listeners\Admin\Tools\Country;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Tools\Country\Delete as Event;
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
            'country.deleted',
            $event->deletedBy,
            $event->country,
            [
                'country_title' => $event->country->title,
            ]
        );

        Activity::create([
            'message' => 'country.deleted',
            'log' => $this->logActivity(
                ' user deleted country ',
                $event->deletedBy,
                $event->country,
                [
                    'country_title' => $event->country->title
                ]
            ),
        ]);
    }
}
