<?php

namespace App\Events\Admin\Settings\Tax;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $id;

    /**
     * Bir vergi silindiğinde tetiklenen olay.
     *
     * @param int $taxId Silinen vergi ID'si
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
