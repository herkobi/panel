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

    public function index(GetAll $countries): View
    {
        $countries = $this->getAll->execute();
        return view('admin.settings.locations.country.index', compact('countries'));
    }

    public function create(): View
    {
        return view('admin.settings.locations.country.create');
    }

    public function store(CountryCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return Redirect::route('panel.settings.locations.countries')->with('success', 'Ülke başarılı bir şekilde eklendi');
    }

    public function edit($id): View
    {
        $country = $this->getOne->execute($id);
        return view('admin.settings.locations.country.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, $id): RedirectResponse
    {
        $country = $this->getOne->execute($id);
        $newStatus = $request->input('status');
        $oldStatus = $country->status->value;

        if ($newStatus != $oldStatus && $this->isDefault($country)) {
            return redirect()->back()->with('error', __('Seçili bölge genel bölge olarak tanımlı. Genel bölgenin durumunu değiştiremezsiniz.'));
        }

        $this->update->execute($id, $request->validated());
        return redirect()->route('panel.settings.locations.countries')->with('success', __('Bölge başarılı bir şekilde güncellendi.'));
    }

    public function destroy($id): RedirectResponse
    {
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

        $this->delete->execute($id);
        return Redirect::route('panel.settings.locations.countries')->with('success', 'Ülke başarılı bir şekilde silindi');

    }

    private function isDefault($country): bool
    {
        return config('panel.location') === $country->code;
    }
}
