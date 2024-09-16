<?php

namespace App\Listeners\Admin\Settings\User;

use App\Events\Admin\Settings\User\Delete as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\AuthUser;
use App\Traits\LogActivity;

class Delete
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
            'user.deleted',
            $event->deletedBy,
            $event->user,
            [
                'user_name' => $event->user->name,
            ]
        );

        Activity::create([
            'message' => 'user.deleted',
            'log' => $this->logActivity(
                ' user deleted by ',
                $event->deletedBy,
                $event->user,
                [
                    'user_name' => $event->user->name
                ]
            ),
        ]);
    }
}
