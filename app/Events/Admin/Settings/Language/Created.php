<?php

namespace App\Events\Admin\Settings\Language;

use App\Models\Language;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }
}
