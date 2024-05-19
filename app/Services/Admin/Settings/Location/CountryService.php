<?php

namespace App\Services\Admin\Settings\Location;

use App\Services\Admin\BaseService;
use App\Models\Country;
use Illuminate\Support\Str;

class CountryService extends BaseService
{

    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if(($action === 'create') ||  ($action === 'update')) {
            $data["slug"] = Str::slug($data["title"] ?? '', '-');
        }

        return $data;
    }

}
