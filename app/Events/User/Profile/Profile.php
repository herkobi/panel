<?php

namespace App\Events\User\Profile;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Profile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $currentUser;
    public $oldData;
    public $newData;


    public function __construct(Authenticatable $currentUser, $oldData, $newData)
    {
        $this->currentUser = $currentUser;
        $this->oldData = $oldData;
        $this->newData = $newData;
    }
}
