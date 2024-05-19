<?php

namespace App\Services\Admin\Settings\Payment;

use App\Services\Admin\BaseService;
use App\Models\Payment;

class Service extends BaseService
{
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }
}
