<?php

namespace App\Events\Admin\Settings\Location\State;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $state;

    public function __construct($id)
    {
        $this->state = $id;
    }
}
