<?php

namespace App\Listeners\User\Profile;

use App\Events\User\Profile\Password as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class Password
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
            'password.updated',
            $event->changedBy,
            null,
            []
        );

        Activity::create([
            'message' => 'password.updated',
            'log' => $this->logActivity(
                ' user updated password.',
                $event->changedBy,
                null,
                []
            ),
        ]);
    }
}
