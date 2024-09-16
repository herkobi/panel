<?php

namespace App\Listeners\Admin\Account;

use App\Events\Admin\Accounts\ChangeEmail as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class ChangeEmail
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
            'user.email.changed',
            $event->changedBy,
            $event->user,
            [
                'new_email' => $event->newEmail,
                'old_email' => $event->user->email
            ]
        );

        Activity::create([
            'message' => 'user.email.changed',
            'log' => $this->logActivity(
                'changed email of',
                $event->changedBy,
                $event->user,
                [
                    'old_email' => $event->user->email,
                    'new_email' => $event->newEmail
                ]
            ),
        ]);
    }
}
