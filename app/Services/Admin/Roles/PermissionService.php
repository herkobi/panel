<?php

namespace App\Services\Admin\Roles;

use App\Services\Admin\BaseService;
use App\Models\Permission;

class PermissionService extends BaseService
{

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

}
