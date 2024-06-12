<?php

namespace App\Events\Admin\Page;

use App\Models\Page;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
    use Dispatchable, SerializesModels;

    public $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }
}
