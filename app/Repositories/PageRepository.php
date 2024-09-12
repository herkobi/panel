<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository extends BaseRepository
{
    protected $model = Page::class;

    public function getBySlug(string $slug)
    {
        return $this->model::where('slug', $slug)->firstOrFail();
    }
}
