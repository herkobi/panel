<?php

namespace App\Events\Admin\Accounts;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class Delete
{
    use Dispatchable, SerializesModels;

    public $user;
    public $deletedBy;

    public function __construct(User $user, Authenticatable $deletedBy)
    {
        $this->user = $user;
        $this->deletedBy = $deletedBy;
    }
}
