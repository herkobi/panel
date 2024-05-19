<?php

namespace App\Services\Admin\Users;

use App\Enums\AccountStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Permission;
use App\Services\Admin\BaseService;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class Service extends BaseService
{
    protected $roleModel;
    protected $permissionModel;

    public function __construct(User $model, Role $roleModel, Permission $permissionModel)
    {
        $this->model = $model;
        $this->roleModel = $roleModel;
        $this->permissionModel = $permissionModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if($action === 'create') {
            $data["type"] = UserType::ADMIN;
            $data["terms"] = 1;
            $data['password'] = Hash::make($data['password']);
            $data['status'] = !isset($data['status']) ? AccountStatus::PASSIVE : AccountStatus::ACTIVE;
            $data['email_verified_at'] = !isset($data['verifyemail']) ? null : Carbon::now()->toDateTimeString();
            $data['created_by'] = auth()->user()->id;
            $data['created_by_name'] = auth()->user()->name . ' ' . auth()->user()->surname;

            $data['settings'] = json_encode([
                'language' => config('panel.language'),
                'timezone' => config('panel.timezone'),
                'dateformat' => config('panel.dateformat'),
                'timeformat' => config('panel.timeformat'),
            ], JSON_UNESCAPED_SLASHES);
        }

        return $data;
    }

    public function getUser(int $userId)
    {
        $user = $this->getById($userId);

        if(!$user) {
            return Redirect::route('panel.users');
        }

        if($user->type === UserType::USER) {
            return Redirect::route('panel.users');
        }

        if(1 === $user->id) {
            return Redirect::route('panel.users');
        }

        if($user->id === auth()->user()->id) {
            return Redirect::route('panel.profile');
        }

        return $user;
    }

    public function getUsers(): Collection
    {
        $users = $this->model->where('type', UserType::ADMIN)->get();
        $filtered = $this->userHasSuperAdmin($users);
        return $filtered;
    }

    protected function userHasSuperAdmin(Collection $users): Collection
    {
        return $users->reject(function ($user) {
            return $user->hasRole('Super Admin');
        });
    }

    protected function filterIsSuperAdmin(Collection $roles): Collection
    {
        return $roles->reject(function ($role) {
            return $role->name === 'Super Admin';
        });
    }

    public function getRoles(): Collection
    {
        $roles = $this->roleModel->where(['type' => UserType::ADMIN, 'status' => Status::ACTIVE])->get();
        $filtered = $this->filterIsSuperAdmin($roles);
        return $filtered;
    }

    public function getPermissions(): Collection
    {
        return $this->permissionModel->all();
    }

}
