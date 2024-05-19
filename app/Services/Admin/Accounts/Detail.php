<?php

namespace App\Services\Admin\Accounts;

use App\Enums\AccountStatus;
use App\Mail\NewAdminUserEmail;
use App\Services\Admin\BaseService;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;

class Detail extends BaseService
{
    protected $model;
    protected $roleModel;
    protected $permissionModel;

    public function __construct(
        User $model,
        Role $roleModel,
        Permission $permissionModel
    )
    {
        $this->model = $model;
        $this->roleModel = $roleModel;
        $this->permissionModel = $permissionModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function updateStatus($id, array $data)
    {
        $user = $this->model->findOrFail($id);
        foreach (AccountStatus::cases() as $AccountStatus) {
            if ($AccountStatus->value == $data['selectedStatus']) {
                $status = $AccountStatus->value;
            }
        }

        $user->update([
            'status' => $status
        ]);

        return $user;
    }

    public function changeEmail($id, array $data)
    {
        $user = $this->model->findOrFail($id);
        if ($data['email'] === $user->email && !($user instanceof MustVerifyEmail)) {
            return null;
        }

        $user->update([
            'email' => $data['email'],
            'email_verified_at' => null
        ]);

        $user->sendEmailVerificationNotification();
        return $user;
    }

    public function verifyEmail($id, array $data)
    {
        $user = $this->model->findOrFail($id);
        if ($data['email'] === $user->email && !($user instanceof MustVerifyEmail)) {
            return null;
        }

        $user->sendEmailVerificationNotification();
        return $user;
    }

    public function checkEmail($id, array $data)
    {
        $user = $this->model->findOrFail($id);
        if ($data['email'] !== $user->email) {
            return null;
        }

        $user->update([
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        return $user;
    }

    public function changePassword($id, array $data)
    {
        $user = $this->model->findOrFail($id);
        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        Mail::to($user->email)->send(new NewAdminUserEmail($user, $data['password']));
        return $user;
    }

    public function authLogs(int $id)
    {
        $user = $this->model->findOrFail($id);
        $logs =  DB::table('auth_logs')->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $logs;
    }

    public function userActivities(int $id): LengthAwarePaginator
    {
        $user = $this->model->findOrFail($id);
        $activities =  Activity::where('causer_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $activities;
    }

}
