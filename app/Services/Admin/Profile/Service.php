<?php

namespace App\Services\Admin\Profile;

use App\Enums\Status;
use App\Mail\NewAdminUserEmail;
use App\Models\User;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Tax;
use App\Services\Admin\BaseService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;

class Service extends BaseService
{
    protected $currencyModel;
    protected $languageModel;
    protected $countryModel;
    protected $taxModel;

    public function __construct(
        User $model,
        Currency $currencyModel,
        Language $languageModel,
        Country $countryModel,
        Tax $taxModel
    )
    {
        $this->model = $model;
        $this->currencyModel = $currencyModel;
        $this->languageModel = $languageModel;
        $this->countryModel = $countryModel;
        $this->taxModel = $taxModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function settingsData()
    {
        return [
            'languages' => $this->getLanguages(),
            'locations' => $this->getLocations(),
            'currencies' => $this->getCurrencies(),
            'taxes' => $this->getTaxes()
        ];
    }

    public function updateProfile($id, $data)
    {
        $user = $this->model->findOrFail($id);
        $user->update([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'title' => $data['title'],
            'about' => $data['about']
        ]);

        return $user;
    }

    public function updateEmail($id, $data)
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

    public function updatePassword($id, $data)
    {
        $user = $this->model->findOrFail($id);
        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        Mail::to($user->email)->send(new NewAdminUserEmail($user, $data['password']));
        return $user;
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

    public function activities($id): LengthAwarePaginator
    {
        $user = $this->getById($id);
        $activities =  Activity::where('causer_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $activities;
    }

    public function authLogs(int $id): LengthAwarePaginator
    {
        $user = $this->getById($id);
        $logs =  DB::table('auth_logs')->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate('40');
        return $logs;
    }

}
