<?php

namespace App\Listeners\Admin\Account;

use App\Events\Admin\Accounts\Create as Event;
use App\Models\Activity;
use App\Services\LoggingService;
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
            'user.created',
            $event->createdBy,
            $event->user,
            [
                'user_name' => $event->userName,
            ]
        );

        Activity::create([
            'message' => 'user.created',
            'log' => $this->logActivity(
                'created new user',
                $event->createdBy,
                $event->user,
                [
                    'user_name' => $event->userName
                ]
            ),
        ]);
    }
}
