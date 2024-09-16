<?php

namespace App\Events\Admin\Settings;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Settings
{
    use Dispatchable, SerializesModels;

    public $updatedBy;
    public $oldSettings;
    public $newSettings;

    public function __construct(Authenticatable $updatedBy, array $oldSettings, array $newSettings)
    {
        $this->updatedBy = $updatedBy;
        $this->oldSettings = $oldSettings;
        $this->newSettings = $newSettings;
    }
}
