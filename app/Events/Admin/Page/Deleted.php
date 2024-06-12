<?php

namespace App\Events\Admin\Page;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $page;

    public function __construct($page)
    {
        $this->page = $page;
    }
}
