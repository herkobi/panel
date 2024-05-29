<?php

namespace App\Services\Admin\Page;

use App\Services\Admin\BaseService;
use App\Models\Page;
use Illuminate\Support\Str;

class Service extends BaseService
{

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

}
