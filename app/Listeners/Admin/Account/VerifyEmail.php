<?php

namespace App\Listeners\Admin\Account;

use App\Events\Admin\Accounts\VerifyEmail as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class VerifyEmail
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
            'user.email.verify.link.sent',
            $event->verifiedBy,
            $event->user,
            []
        );

        Activity::create([
            'message' => 'user.email.verify.link.sent',
            'log' => $this->logActivity(
                'email verify link sent of',
                $event->verifiedBy,
                $event->user,
                []
            ),
        ]);
    }
}
