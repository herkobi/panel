<?php

namespace App\Events\Admin\Gateways\Bac;

use App\Models\Gateway;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }
}
