<?php

namespace App\Events\Admin\Settings\Page;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Page;
use Illuminate\Contracts\Auth\Authenticatable;

class Update
{
    use Dispatchable, SerializesModels;

    public $page;
    public $changedBy;
    public $oldPage;
    public $newPage;

    public function __construct(Page $page, Authenticatable $changedBy, string $oldPage, string $newPage)
    {
        $this->page = $page;
        $this->changedBy = $changedBy;
        $this->oldPage = $oldPage;
        $this->newPage = $newPage;
    }
}
