<?php

namespace App\Actions\Admin\Settings\Page;

use App\Services\Admin\Settings\PageService;
use App\Events\Admin\Settings\Page\Delete as Event;
use App\Models\Page;
use App\Traits\AuthUser;

class Delete
{
    use AuthUser;

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->initializeAuthUser();
    }

    public function execute(string $id): Page
    {
        $page = $this->pageService->getPageById($id);
        $this->pageService->deletePage($id);
        event(new Event($page, $this->user));
        return $page;
    }
}
