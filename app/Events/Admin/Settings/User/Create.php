<?php

namespace App\Events\Admin\Settings\User;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Create
{
    use Dispatchable, SerializesModels;

    public $user;
    public $createdBy;
    public $userName;

    public function __construct(User $user, Authenticatable $createdBy, string $userName)
    {
        $this->user = $user;
        $this->createdBy = $createdBy;
        $this->userName = $userName;
    }
}
