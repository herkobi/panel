<?php

namespace App\Services\Admin\Roles;

use App\Models\Permission;
use App\Services\Admin\BaseService;
use App\Models\Role;
use Illuminate\Support\Collection;

class RoleService extends BaseService
{

    protected $model;
    protected $permissionModel;

    public function __construct(
        Role $model,
        Permission $permissionModel
    )
    {
        $this->model = $model;
        $this->permissionModel = $permissionModel;
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

    public function detailRole(int $id): array
    {
        $role = $this->getById($id);
        return $this->permissionModel->join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $role->id)->pluck('permission_id')->toArray();
    }

    // RoleService içinde yeni bir metod ekle
    protected function filterRoles(Collection $roles): Collection
    {
        // Super Admin rolünü filtrele
        return $roles->reject(function ($role) {
            return $role->name === 'Super Admin';
        });
    }

    public function permissions(int $id): Collection
    {
        $role = $this->getById($id);
        return $this->permissionModel->with('children')->where('parent_id', 0)->where('type', $role->type)->get();
    }

    public function syncPermissions(int $id, $request)
    {
        $role = $this->getById($id);
        $permissionIds = (array)$request->input('permission', []);

        // İzin ID'lerini `Permission` modellerine çevirin ve isimlerini alın
        $permissionNames = $this->permissionModel->whereIn('id', $permissionIds)->pluck('name')->toArray();

        // İzinleri role'a senkronize edin
        return $role->syncPermissions($permissionNames);
    }

}
