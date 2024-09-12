<?php

namespace App\Events\Admin\Settings\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class ChangeEmail
{
    use Dispatchable, SerializesModels;

    public $user;
    public $changedBy;
    public $newEmail;

    public function __construct(User $user, Authenticatable $changedBy, string $newEmail)
    {
        $this->user = $user;
        $this->changedBy = $changedBy;
        $this->newEmail = $newEmail;
    }
}
