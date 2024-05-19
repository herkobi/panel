<?php

namespace App\Services\Admin\Settings\Tax;

use App\Services\Admin\BaseService;
use App\Models\Tax;
use App\Models\Country;
use Illuminate\Support\Str;

class Service extends BaseService
{
    protected $countryModel;

    public function __construct(Tax $model, Country $countryModel)
    {
        $this->model = $model;
        $this->countryModel = $countryModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if(($action === 'create') ||  ($action === 'update')) {
            $data["slug"] = Str::slug($data["slug"] ?? '', '-');
        }

        return $data;
    }

    /**
     * Ülkelerin listesini getirir.
     *
     * @return array
     */
    public function getCountries(): array
    {
        return $this->countryModel->pluck('title', 'id')->toArray();
    }
}
