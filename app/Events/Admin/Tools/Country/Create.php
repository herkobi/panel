<?php

namespace App\Events\Admin\Tools\Country;

use App\Models\Country;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class Create
{
    use Dispatchable, SerializesModels;

    public $country;
    public $createdBy;

    public function __construct(Country $country, Authenticatable $createdBy)
    {
        $this->country = $country;
        $this->createdBy = $createdBy;
    }
}
