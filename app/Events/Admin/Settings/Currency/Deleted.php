<?php

namespace App\Events\Admin\Settings\Currency;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $currency;

    public function __construct($id)
    {
        $this->currency = $id;
    }
}
