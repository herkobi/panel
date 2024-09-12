<?php

namespace App\Events\Admin\Settings\Page;

use App\Models\Page;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class Create
{
    use Dispatchable, SerializesModels;

    public $page;
    public $createdBy;

    public function __construct(Page $page, Authenticatable $createdBy)
    {
        $this->page = $page;
        $this->createdBy = $createdBy;
    }
}
