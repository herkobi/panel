<?php

namespace App\Listeners\Admin\Account;

use App\Events\Admin\Accounts\StatusUpdate as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class StatusUpdate
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
            'user.status.updated',
            $event->changedBy,
            $event->user,
            [
                'new_status' => $event->newStatus,
                'old_status' => $event->user->status->value
            ]
        );

        Activity::create([
            'message' => 'user.status.updated',
            'log' => $this->logActivity(
                'user updated status of',
                $event->changedBy,
                $event->user,
                [
                    'old_status' => $event->user->email,
                    'new_status' => $event->newStatus
                ]
            ),
        ]);
    }
}
