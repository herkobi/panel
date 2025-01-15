<?php

namespace App\Events\Admin\Tools\Country;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;
use Illuminate\Contracts\Auth\Authenticatable;

class Update
{
    use Dispatchable, SerializesModels;

    public $country;
    public $changedBy;
    public $oldCountry;
    public $newCountry;

    public function __construct(Country $country, Authenticatable $changedBy, string $oldCountry, string $newCountry)
    {
        $this->country = $country;
        $this->changedBy = $changedBy;
        $this->oldCountry = $oldCountry;
        $this->newCountry = $newCountry;
    }
}
