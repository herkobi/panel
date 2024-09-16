<?php

namespace App\Events\Admin\Accounts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class StatusUpdate
{
    use Dispatchable, SerializesModels;

    public $user;
    public $changedBy;
    public $newStatus;

    public function __construct(User $user, Authenticatable $changedBy, string $newStatus)
    {
        $this->user = $user;
        $this->changedBy = $changedBy;
        $this->newStatus = $newStatus;
    }
}
