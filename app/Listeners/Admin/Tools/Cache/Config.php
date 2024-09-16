<?php

namespace App\Listeners\Admin\Tools\Cache;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Tools\Cache\Cache as Event;
use App\Traits\LogActivity;

class Config
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
            'config.cache.cleared',
            $event->clearedBy,
            null,
            []
        );

        Activity::create([
            'message' => 'config.cache.cleared',
            'log' => $this->logActivity(
                ' user cleared config cache.',
                $event->clearedBy,
                null,
                []
            ),
        ]);
    }
}
