<?php

namespace App\Services\Admin\Settings\Settings;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Tax;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SystemService extends BaseService
{

    const KEY = 'settings';

    protected $model;
    protected $roleModel;
    protected $currencyModel;
    protected $languageModel;
    protected $countryModel;
    protected $taxModel;

    public function __construct(
        Setting $model,
        Role $roleModel,
        Currency $currencyModel,
        Language $languageModel,
        Country $countryModel,
        Tax $taxModel
    )
    {
        $this->model = $model;
        $this->roleModel = $roleModel;
        $this->currencyModel = $currencyModel;
        $this->languageModel = $languageModel;
        $this->countryModel = $countryModel;
        $this->taxModel = $taxModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function updateData(Request $request)
    {
        $data = [];

        $data['usersettings'] = $request->input('usersettings', config('panel.usersettings'));
        $data['userrole'] = $request->input('userrole', config('panel.userrole'));
        $data['adminrole'] = $request->input('adminrole', config('panel.adminrole'));
        $data['language'] = $request->input('language', config('panel.language'));
        $data['location'] = $request->input('location', config('panel.location'));
        $data['currency'] = $request->input('currency', config('panel.currency'));
        $data['tax'] = $request->input('tax', config('panel.tax'));
        $data['timezone'] = $request->input('timezone', config('panel.timezone'));
        $data['dateformat'] = $request->input('dateformat', config('panel.dateformat'));
        $data['timeformat'] = $request->input('timeformat', config('panel.timeformat'));

        $setting = $this->model->firstWhere('key', self::KEY)->update([
            'value' => json_encode($data),
        ]);

        return $setting;
    }

    public function settingsData()
    {
        return [
            'userroles' => $this->getUserRoles(),
            'adminroles' => $this->getAdminRoles(),
            'languages' => $this->getLanguages(),
            'locations' => $this->getLocations(),
            'currencies' => $this->getCurrencies(),
            'taxes' => $this->getTaxes()
        ];
    }

    protected function getUserRoles(): Collection
    {
        return $this->roleModel->where('type', UserType::USER)->get();
    }

    protected function getAdminRoles(): Collection
    {
        $roles = $this->roleModel->where('type', UserType::ADMIN)->get();
        $filteredRoles = $this->filterRoles($roles);

        return $filteredRoles;
    }

    protected function filterRoles(Collection $roles): Collection
    {
        return $roles->reject(function ($role) {
            return $role->name === 'Super Admin';
        });
    }

    protected function getLanguages(): Collection
    {
        return $this->languageModel->where('status', Status::ACTIVE)->get();
    }

    protected function getLocations(): Collection
    {
        return $this->countryModel->where('status', Status::ACTIVE)->get();
    }

    protected function getCurrencies(): Collection
    {
        return $this->currencyModel->where('status', Status::ACTIVE)->get();
    }

    protected function getTaxes(): Collection
    {
        return $this->taxModel->where('status', Status::ACTIVE)->get();
    }

}
