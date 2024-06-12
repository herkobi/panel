<?php

namespace App\Events\Admin\Settings\Tax;

use App\Models\Tax;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $tax;

    /**
     * Yeni bir vergi oluşturulduğunda tetiklenen olay.
     *
     * @param Tax $tax Oluşturulan vergi modeli
     */
    public function __construct(Tax $tax)
    {
        $this->tax = $tax;
    }
}
