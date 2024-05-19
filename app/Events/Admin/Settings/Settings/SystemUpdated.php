<?php

namespace App\Events\Admin\Settings\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemUpdated
{
    use Dispatchable, SerializesModels;

    public $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
}
