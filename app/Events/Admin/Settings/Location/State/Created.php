<?php

namespace App\Events\Admin\Settings\Location\State;

use App\Models\State;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }
}
