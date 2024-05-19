<?php

namespace App\Events\Admin\Roles\Permission;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $permission;

    public function __construct($id)
    {
        $this->permission = $id;
    }
}
