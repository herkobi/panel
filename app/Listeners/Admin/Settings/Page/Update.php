<?php

namespace App\Listeners\Admin\Settings\Page;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Settings\Page\Update as Event;
use App\Traits\LogActivity;

class Update
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
            'page.updated',
            $event->changedBy,
            $event->page,
            [
                'new_page' => $event->newPage,
                'old_page' => $event->oldPage
            ]
        );

        Activity::create([
            'message' => 'page.updated',
            'log' => $this->logActivity(
                'user updated page of',
                $event->changedBy,
                $event->page,
                [
                    'old_page' => $event->oldPage,
                    'new_page' => $event->newPage
                ]
            ),
        ]);
    }
}
