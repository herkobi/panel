<?php

namespace App\Services\Admin\Tools;

use Spatie\Activitylog\Models\Activity;
use App\Services\Admin\BaseService;
use Illuminate\Support\Facades\Artisan;

class CacheService extends BaseService
{

    public function __construct(Activity $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function clearCache()
    {
        return Artisan::call('cache:clear');
    }

    public function clearConfig()
    {
        return Artisan::call('config:clear');
    }

    public function clearOptimize()
    {
        return Artisan::call('optimize:clear');
    }

    public function clearView()
    {
        return Artisan::call('view:clear');
    }

    public function clearRoute()
    {
        return Artisan::call('route:clear');
    }

}
