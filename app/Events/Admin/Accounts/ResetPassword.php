<?php

namespace App\Events\Admin\Accounts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPassword
{
    use Dispatchable, SerializesModels;

    public $user;
    public $changedBy;
    public $status;

    public function __construct(User $user, Authenticatable $changedBy, $status)
    {
        $this->user = $user;
        $this->changedBy = $changedBy;
        $this->status = $status;
    }
}
