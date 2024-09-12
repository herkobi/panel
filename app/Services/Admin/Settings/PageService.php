<?php

namespace App\Services\Admin\Settings;

use App\Repositories\PageRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Page;

class PageService
{
    protected $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPages(): LengthAwarePaginator
    {
        return $this->repository->getAll();
    }

    public function getPageById(string $id, bool $withoutGlobalScope = false): Page
    {
        return $this->repository->getById($id, $withoutGlobalScope);
    }

    public function createPage(array $data): Page
    {
        return $this->repository->create($data);
    }

    public function updatePage(string $id, array $data): Page
    {
        return $this->repository->update($id, $data);
    }

    public function deletePage(string $id): void
    {
        $this->repository->delete($id);
    }
}
