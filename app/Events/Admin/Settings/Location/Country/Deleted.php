<?php

namespace App\Events\Admin\Settings\Location\Country;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $country;

    public function __construct($id)
    {
        $this->country = $id;
    }
}
