<?php

namespace App\Events\Admin\Tools\Language;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Language;
use Illuminate\Contracts\Auth\Authenticatable;

class Delete
{
    use Dispatchable, SerializesModels;

    public $language;
    public $deletedBy;

    public function __construct(Language $language, Authenticatable $deletedBy)
    {
        $this->language = $language;
        $this->deletedBy = $deletedBy;
    }
}
