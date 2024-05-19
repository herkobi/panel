<?php

namespace App\Events\Admin\Gateways\Bac;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $gateway;

    public function __construct($id)
    {
        $this->gateway = $id;
    }
}
