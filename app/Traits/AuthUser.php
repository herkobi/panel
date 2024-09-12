<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AuthUser
{
    protected ?User $user;

    protected function initializeAuthUser()
    {
        $this->user = Auth::user();
    }
}
