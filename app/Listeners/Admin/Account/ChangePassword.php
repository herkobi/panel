<?php

namespace App\Listeners\Admin\Account;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Accounts\ChangePassword as Event;
use App\Traits\LogActivity;

class ChangePassword
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
            []
        );

        Activity::create([
            'message' => 'user.password.changed',
            'log' => $this->logActivity(
                'changed password of',
                $event->changedBy,
                $event->user,
                []
            ),
        ]);
    }
}
