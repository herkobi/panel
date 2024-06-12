<?php

namespace App\Services\Admin\Roles;

use App\Services\Admin\BaseService;
use App\Models\Permission;
use Illuminate\Support\Collection;

class PermissionService extends BaseService
{

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if($action === 'create') {
            $guard = 'web';
            $data["guard_name"] = $guard;
        }
        return $data;
    }

    public function allPermissions(): Collection
    {
        return $this->model->with('children')->where('parent_id', 0)->get();
    }

    public function mainPermissions(): Collection
    {
        return $this->model->where('parent_id', 0)->get();
    }

}
