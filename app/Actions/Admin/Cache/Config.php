<?php

namespace App\Actions\Admin\Cache;

use App\Events\Admin\Tools\Cache\Config as Event;
use App\Traits\AuthUser;
use Illuminate\Support\Facades\Artisan;

class Config
{
    use AuthUser;
    protected $userService;

    public function __construct()
    {
        $this->initializeAuthUser();
    }
    public function execute()
    {
        $cache = Artisan::call('config:clear');
        event(new Event($this->user, $cache));
        return $cache;
    }
}
