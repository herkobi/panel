<?php

namespace App\Services\Admin\Profile;

use App\Models\User;
use App\Services\Admin\BaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;

class Service extends BaseService
{
    protected $roleModel;
    protected $permissionModel;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function getUser(int $userId)
    {
        $user = $this->getById($userId);

        if(!$user) {
            return Redirect::route('panel.users');
        }

        return $user;
    }

    public function activities($id): LengthAwarePaginator
    {
        $user = $this->model->findOrFail($id);
        $activities =  Activity::where('causer_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $activities;
    }

    public function authLogs(int $id): LengthAwarePaginator
    {
        $user = $this->model->findOrFail($id);
        $logs =  DB::table('auth_logs')->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $logs;
    }

}
