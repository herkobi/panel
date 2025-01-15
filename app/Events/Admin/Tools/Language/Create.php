<?php

namespace App\Events\Admin\Tools\Language;

use App\Models\Language;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class Create
{
    use Dispatchable, SerializesModels;

    public $language;
    public $createdBy;

    public function __construct(Language $language, Authenticatable $createdBy)
    {
        $this->language = $language;
        $this->createdBy = $createdBy;
    }
}
