<?php

namespace App\Events\Admin\Profile;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Email
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $currentUser;
    public $oldMail;
    public $newMail;


    public function __construct(Authenticatable $currentUser, $oldMail, $newMail)
    {
        $this->currentUser = $currentUser;
        $this->oldMail = $oldMail;
        $this->newMail = $newMail;
    }
}
