<?php

namespace App\Actions\Admin\Settings\Page;

use App\Models\Page;
use App\Services\Admin\Settings\PageService;
use App\Events\Admin\Settings\Page\Create as Event;
use App\Traits\AuthUser;

class Create
{
    use AuthUser;

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->initializeAuthUser();
    }

    public function execute(array $data): Page
    {
        $page = $this->pageService->createPage($data);
        event(new Event($page, $this->user));
        return $page;
    }
}
