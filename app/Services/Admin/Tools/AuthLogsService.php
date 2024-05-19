<?php

namespace App\Services\Admin\Tools;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Services\Admin\BaseService;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AuthLogsService extends BaseService
{

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function getUser(int $id)
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Hesaplara ait işlemlerin kayıtlarını getirir.
     *
     * @return array
     */
    public function getAccountLogs(): Collection
    {
        return $this->model->select('id', 'name', 'surname', 'title', 'last_login_ip', 'last_login_at', 'agent')
            ->where('type', UserType::USER)
            ->whereNotIn('status', [AccountStatus::DELETED])
            ->whereNotNull('last_login_at')
            ->get();
    }

    /**
     * Kullanıcılara ait işlemlerin kayıtlarını getirir.
     *
     * @return array
     */
    public function getUserLogs(): Collection
    {
        return $this->model->select('id', 'name', 'surname', 'title', 'last_login_ip', 'last_login_at', 'agent')
            ->where('type', UserType::ADMIN)
            ->whereNotIn('status', [AccountStatus::DELETED])
            ->whereNotNull('last_login_at')
            ->where('id', '<>', User::role('Super Admin')->first()->id)
            ->get();
    }

    /**
     * Kullanıcıya ait oturum kayıtlarını getirir.
     *
     * @return array
     */
    public function authLogs(int $id): Collection
    {
        $user = $this->model->findOrFail($id);
        $logs =  DB::table('auth_logs')->where('user_id', $user->id)->get();
        return $logs;
    }

}
