<?php

namespace App\Events\Admin\Settings\User;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CheckEmail
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
