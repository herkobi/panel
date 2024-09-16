<?php

namespace App\Listeners\Admin\Settings\User;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Settings\User\CheckEmail as Event;
use App\Traits\LogActivity;

class CheckEmail
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
            'user.email.approved',
            $event->changedBy,
            $event->user,
            []
        );

        Activity::create([
            'message' => 'user.email.approved',
            'log' => $this->logActivity(
                'approved email of',
                $event->changedBy,
                $event->user,
                []
            ),
        ]);
    }
}
