<?php

namespace App\Listeners\Admin\Profile;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Profile\Profile as Event;
use App\Traits\LogActivity;

class Profile
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
            'profile.updated',
            $event->currentUser,
            $event->newData,
            [
                'new_data' => $event->newData,
                'old_data' => $event->oldData
            ]
        );

        Activity::create([
            'message' => 'profile.updated',
            'log' => $this->logActivity(
                ' user updated profile.',
                $event->currentUser,
                $event->newData,
                [
                    'old_data' => $event->oldData,
                    'new_data' => $event->newData
                ]
            ),
        ]);
    }
}
