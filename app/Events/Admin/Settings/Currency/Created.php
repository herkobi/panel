<?php

namespace App\Events\Admin\Settings\Currency;

use App\Models\Currency;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }
}
