<?php

namespace App\Actions\Admin\Cache;

use App\Events\Admin\Tools\Cache\Route as Event;
use App\Traits\AuthUser;
use Illuminate\Support\Facades\Artisan;

class Route
{
    use AuthUser;
    protected $userService;

    public function __construct()
    {
        $this->initializeAuthUser();
    }
    public function execute()
    {
        $cache = Artisan::call('route:clear');
        event(new Event($this->user, $cache));
        return $cache;
    }
}
