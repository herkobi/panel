<?php

namespace App\Services\Admin\Tools;

use Spatie\Activitylog\Models\Activity;
use App\Services\Admin\BaseService;

class ActivitiesService extends BaseService
{

    public function __construct(Activity $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function userActivities()
    {
        return $this->model->where('log_name', 'panel')->orderBy('created_at', 'desc')->paginate('40');
    }

    public function accountActivities()
    {
        return $this->model->where('log_name', 'app')->orderBy('created_at', 'desc')->paginate('40');

    }

}
