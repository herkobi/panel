<?php

namespace App\Events\Admin\Tools\Cache;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class View
{
    use Dispatchable, SerializesModels;

    public $clearedBy;
    public $cache;

    public function __construct(Authenticatable $clearedBy, string $cache)
    {
        $this->clearedBy = $clearedBy;
        $this->cache = $cache;
    }
}
