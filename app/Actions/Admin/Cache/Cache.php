<?php

namespace App\Actions\Admin\Cache;

use App\Traits\AuthUser;
use App\Events\Admin\Tools\Cache\Cache as Event;
use Illuminate\Support\Facades\Artisan;

class Cache
{
    use AuthUser;
    protected $userService;

    public function __construct()
    {
        $this->initializeAuthUser();
    }
    public function execute()
    {
        $cache = Artisan::call('cache:clear');
        event(new Event($this->user, $cache));
        return $cache;
    }
}
