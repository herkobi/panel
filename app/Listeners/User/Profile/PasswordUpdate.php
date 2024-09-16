<?php

namespace App\Listeners\User\Profile;

use App\Events\User\Profile\Password as PasswordEvent;
use App\Services\LoggingService;

class PasswordUpdate
{
    protected $loggingService;

    public function __construct(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    public function handle(PasswordEvent $event)
    {
        $this->loggingService->logUserAction(
            'password_changed',
            $event->user,
            $event->user
        );
    }
}
