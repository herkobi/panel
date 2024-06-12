<?php

namespace App\Events\Admin\Settings\Settings;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppUpdated
{
    use Dispatchable, SerializesModels;

    public $setting;
    public $type;

    public function __construct($settings, $type)
    {
        $this->setting = $settings;
        $this->type = $type;
    }
}
