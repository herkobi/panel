<?php

namespace App\Events\Admin\Accounts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChangePassword
{
    use Dispatchable, SerializesModels;

    public $user;
    public $changedBy;

    public function __construct(User $user, Authenticatable $changedBy)
    {
        $this->user = $user;
        $this->changedBy = $changedBy;
    }
}
