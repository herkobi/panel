<?php

namespace App\Listeners\Admin\Settings\Page;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Settings\Page\Delete as Event;
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
            'page.deleted',
            $event->deletedBy,
            $event->page,
            [
                'page_title' => $event->page->title,
            ]
        );

        Activity::create([
            'message' => 'page.deleted',
            'log' => $this->logActivity(
                ' user deleted page ',
                $event->deletedBy,
                $event->page,
                [
                    'page_title' => $event->page->title
                ]
            ),
        ]);
    }
}
