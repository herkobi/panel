<?php

namespace App\Events\Admin\Roles\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
}
