<?php

namespace App\Listeners\Admin\Tools\Country;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Tools\Country\Update as Event;
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
            'country.updated',
            $event->changedBy,
            $event->country,
            [
                'new_country' => $event->newCountry,
                'old_country' => $event->oldCountry
            ]
        );

        Activity::create([
            'message' => 'country.updated',
            'log' => $this->logActivity(
                'user updated country of',
                $event->changedBy,
                $event->country,
                [
                    'old_country' => $event->oldCountry,
                    'new_country' => $event->newCountry
                ]
            ),
        ]);
    }
}
