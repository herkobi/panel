<?php

namespace App\Events\Admin\Settings\Location\Country;

use App\Models\Country;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }
}
