<?php

namespace App\Services\Admin\Settings\Language;

use App\Services\Admin\BaseService;
use App\Models\Language;

class Service extends BaseService
{

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

}
