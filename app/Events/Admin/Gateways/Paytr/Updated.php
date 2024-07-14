<?php

namespace App\Events\Admin\Gateways\Paytr;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated
{
    use Dispatchable, SerializesModels;

    public $oldTitle;
    public $newTitle;

    public function __construct($oldTitle, $newTitle)
    {
        $this->oldTitle = $oldTitle;
        $this->newTitle = $newTitle;
    }
}
