<?php

namespace App\Actions\Admin\Cache;

use App\Events\Admin\Tools\Cache\Event as EventEvent;
use App\Traits\AuthUser;
use Illuminate\Support\Facades\Artisan;

class Event
{
    use AuthUser;
    protected $userService;

    public function __construct()
    {
        $this->initializeAuthUser();
    }
    public function execute()
    {
        $cache = Artisan::call('event:clear');
        event(new EventEvent($this->user, $cache));
        return $cache;
    }
}
