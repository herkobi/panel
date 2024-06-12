<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Location\CountryCreateRequest;
use App\Http\Requests\Admin\Settings\Location\CountryUpdateRequest;
use App\Actions\Admin\Settings\Location\Country\Create;
use App\Actions\Admin\Settings\Location\Country\Update;
use App\Actions\Admin\Settings\Location\Country\Delete;
use App\Actions\Admin\Settings\Location\Country\GetAll;
use App\Actions\Admin\Settings\Location\Country\GetOne;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CountryController extends Controller
{

    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function index(GetAll $countries): View|RedirectResponse
    {
        if (!auth()->user()?->can('location.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $countries = $this->getAll->execute();
        return view('admin.settings.locations.country.index', [
            'countries' => $countries
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (!auth()->user()?->can('location.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        return view('admin.settings.locations.country.create');
    }

    public function store(CountryCreateRequest $request): RedirectResponse
    {
        if (!auth()->user()?->can('location.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.settings.locations.countries')->with('success', 'Ülke başarılı bir şekilde eklendi')
                : Redirect::back()->with('error', 'Ülke eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View|RedirectResponse
    {
        if (!auth()->user()?->can('location.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $country = $this->getOne->execute($id);
        return view('admin.settings.locations.country.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()?->can('location.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $country = $this->getOne->execute($id);
        $newStatus = $request->input('status');
        $oldStatus = $country->status->value;

        if ($newStatus != $oldStatus && $this->isDefault($country)) {
            return Redirect::back()->with('error', 'Seçili bölge genel bölge olarak tanımlı. Genel bölgenin durumunu değiştiremezsiniz.');
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.settings.locations.countries')->with('success', 'Bölge başarılı bir şekilde güncellendi.')
                : Redirect::back()->with('error', 'Bölge güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()?->can('location.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $country = $this->getOne->execute($id);
        if (!$country) {
            return Redirect::back()->with('error', 'Ülke bulunamadı');
        }

        if ($this->isDefault($country)) {
            return Redirect::back()->with('error', 'Seçili ülke genel bölge olarak tanımlı. Lütfen önce sistem ayarlarından bu değeri değiştiriniz.');
        }

        if($country->states()->count() > 0)
        {
            return Redirect::back()->with('error', 'Bu ülkeye ait eyalet/şehir kayıtları olduğu için silme işlemi gerçekleştirilemedi.');
        }

        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.settings.locations.countries')->with('success', 'Ülke başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Ülke silinirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    private function isDefault($country): bool
    {
        return config('panel.location') === $country->code;
    }
}
