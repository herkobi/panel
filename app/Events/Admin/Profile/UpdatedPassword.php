<?php

namespace App\Events\Admin\Profile;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedPassword
{
    use Dispatchable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
