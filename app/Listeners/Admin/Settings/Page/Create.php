<?php

namespace App\Listeners\Admin\Settings\Page;

use App\Events\Admin\Settings\Page\Create as Event;
use App\Models\Activity;
use App\Services\LoggingService;
use App\Traits\LogActivity;

class Create
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
            'page.created',
            $event->createdBy,
            $event->page,
            [
                'page_title' => $event->page->title,
            ]
        );

        Activity::create([
            'message' => 'page.created',
            'log' => $this->logActivity(
                ' user created new page',
                $event->createdBy,
                $event->page,
                [
                    'page_title' => $event->page->title,
                ]
            ),
        ]);
    }
}
