<?php

namespace App\Events\Admin\Settings\Page;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Page;
use Illuminate\Contracts\Auth\Authenticatable;

class Delete
{
    use Dispatchable, SerializesModels;

    public $page;
    public $deletedBy;

    public function __construct(Page $page, Authenticatable $deletedBy)
    {
        $this->page = $page;
        $this->deletedBy = $deletedBy;
    }
}
