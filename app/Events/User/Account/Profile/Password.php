<?php

namespace App\Events\User\Account\Profile;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class Password
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $changedBy;

    public function __construct(Authenticatable $changedBy)
    {
        $this->changedBy = $changedBy;
    }
}
