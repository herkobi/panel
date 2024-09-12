<?php

namespace App\Actions\Admin\Settings\Page;

use App\Services\Admin\Settings\PageService;
use App\Events\Admin\Settings\Page\Update as Event;
use App\Models\Page;
use App\Traits\AuthUser;

class Update
{
    use AuthUser;

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->initializeAuthUser();
    }

    public function execute(string $id, array $data): Page
    {
        $oldPage = $this->pageService->getPageById($id);
        $page = $this->pageService->updatePage($id, $data);
        $newPage = $this->pageService->getPageById($id);
        event(new Event($page, $this->user, $oldPage, $newPage));
        return $page;
    }
}
