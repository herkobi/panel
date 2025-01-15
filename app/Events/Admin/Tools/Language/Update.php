<?php

namespace App\Events\Admin\Tools\Language;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Language;
use Illuminate\Contracts\Auth\Authenticatable;

class Update
{
    use Dispatchable, SerializesModels;

    public $language;
    public $changedBy;
    public $oldLanguage;
    public $newLanguage;

    public function __construct(Language $language, Authenticatable $changedBy, string $oldLanguage, string $newLanguage)
    {
        $this->language = $language;
        $this->changedBy = $changedBy;
        $this->oldLanguage = $oldLanguage;
        $this->newLanguage = $newLanguage;
    }
}
