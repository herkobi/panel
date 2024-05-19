<?php

namespace App\Events\Admin\Settings\Language;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $language;

    public function __construct($id)
    {
        $this->language = $id;
    }
}
