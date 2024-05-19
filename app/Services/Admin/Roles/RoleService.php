<?php

namespace App\Services\Admin\Roles;

use App\Services\Admin\BaseService;
use App\Models\Role;
use Illuminate\Support\Collection;

class RoleService extends BaseService
{

    public function __construct(Role $model)
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

    // RoleService içinde getAll metodu özelleştirme
    public function getRoles(): Collection
    {
        // Tüm rolleri getir
        $roles = $this->model::all();

        // Super Admin rolünü filtrele
        $filteredRoles = $this->filterRoles($roles);

        return $filteredRoles;
    }

    // RoleService içinde yeni bir metod ekle
    protected function filterRoles(Collection $roles): Collection
    {
        // Super Admin rolünü filtrele
        return $roles->reject(function ($role) {
            return $role->name === 'Super Admin';
        });
    }

}
