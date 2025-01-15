<?php

namespace App\Events\Admin\Tools\Country;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;
use Illuminate\Contracts\Auth\Authenticatable;

class Delete
{
    use Dispatchable, SerializesModels;

    public $country;
    public $deletedBy;

    public function __construct(Country $country, Authenticatable $deletedBy)
    {
        $this->country = $country;
        $this->deletedBy = $deletedBy;
    }
}
