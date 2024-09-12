<?php

namespace App\Listeners\Admin\Profile;

use App\Events\Admin\Profile\Profile as ProfileEvent;
use App\Services\LoggingService;

class ProfileUpdate
{
    protected $loggingService;

    public function __construct(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    public function handle(ProfileEvent $event)
    {
        $this->loggingService->logUserAction(
            'profile_updated',
            $event->user,
            $event->user
        );
    }
}
