<?php

namespace App\Events\Admin\Settings\User;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyEmail
{
    use Dispatchable, SerializesModels;

    public $user;
    public $verifiedBy;

    public function __construct(User $user, Authenticatable $verifiedBy)
    {
        $this->user = $user;
        $this->verifiedBy = $verifiedBy;
    }
}
