<?php

namespace App\Events\Admin\Roles\Role;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $role;

    public function __construct($id)
    {
        $this->role = $id;
    }
}
