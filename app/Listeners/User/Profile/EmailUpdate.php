<?php

namespace App\Listeners\User\Profile;

use App\Events\User\Profile\Email as EmailEvent;
use App\Services\LoggingService;

class EmailUpdate
{
    protected $loggingService;

    public function __construct(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    public function handle(EmailEvent $event)
    {
        $this->loggingService->logUserAction(
            'email_changed',
            $event->user,
            $event->user,
            ['new_email' => $event->user->email]
        );
    }
}
