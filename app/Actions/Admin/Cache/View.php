<?php

namespace App\Actions\Admin\Cache;

use App\Events\Admin\Tools\Cache\View as Event;
use App\Traits\AuthUser;
use Illuminate\Support\Facades\Artisan;

class View
{
    use AuthUser;
    protected $userService;

    public function __construct()
    {
        $this->initializeAuthUser();
    }
    public function execute()
    {
        $cache = Artisan::call('view:clear');
        event(new Event($this->user, $cache));
        return $cache;
    }
}
