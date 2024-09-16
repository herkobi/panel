<?php

namespace App\Listeners\Admin\Profile;

use App\Events\Admin\Profile\Email as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class Email
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
            'email.updated',
            $event->currentUser,
            $event->newMail,
            [
                'new_data' => $event->newMail,
                'old_data' => $event->oldMail
            ]
        );

        Activity::create([
            'message' => 'email.updated',
            'log' => $this->logActivity(
                ' user updated e-mail.',
                $event->currentUser,
                $event->newMail,
                [
                    'old_data' => $event->oldMail,
                    'new_data' => $event->newMail
                ]
            ),
        ]);
    }
}
