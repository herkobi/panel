<?php

namespace App\Services\Admin\Settings\Currency;

use App\Services\Admin\BaseService;
use App\Models\Currency;

class Service extends BaseService
{

    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

}
