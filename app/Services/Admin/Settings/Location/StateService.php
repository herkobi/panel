<?php

namespace App\Services\Admin\Settings\Location;

use App\Services\Admin\BaseService;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StateService extends BaseService
{
    protected $model;
    protected $countryModel;

    public function __construct(
        State $model,
        Country $countryModel
    )
    {
        $this->model = $model;
        $this->countryModel = $countryModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if(($action === 'create') ||  ($action === 'update')) {
            $data["slug"] = Str::slug($data["title"] ?? '', '-');
        }

        return $data;
    }

    /**
     * Belirli bir ülkeye ait tüm eyaletleri getirir.
     *
     * @param int $countryId
     * @return Collection
     */
    public function getStatesByCountry(int $countryId): Collection
    {
        return $this->model->where('country_id', $countryId)->get();
    }

    /**
     * Belirli bir ülkeye ait tüm eyaletleri getirir.
     *
     * @param int $countryId
     * @return \App\Models\Country|null
     */
    public function getCountry(int $countryId)
    {
        return $this->countryModel->where('id', $countryId)->first();
    }
}
