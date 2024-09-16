<?php

namespace App\Listeners\Admin\Account;

use App\Events\Admin\Accounts\ResetPassword as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class ResetPassword
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
            'user.password.changed',
            $event->changedBy,
            $event->user,
            [
                'status' => $event->status
            ]
        );

        Activity::create([
            'message' => 'user.password.reset',
            'log' => $this->logActivity(
                ' password reset link sended of',
                $event->changedBy,
                $event->user,
                [
                    'status' => $event->status
                ]
            ),
        ]);
    }
}
