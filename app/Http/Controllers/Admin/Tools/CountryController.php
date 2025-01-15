<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Services\Admin\Tools\CountryService;
use App\Actions\Admin\Tools\Country\Create;
use App\Actions\Admin\Tools\Country\Update;
use App\Actions\Admin\Tools\Country\Delete;
use App\Http\Requests\Admin\Tools\Country\CountryUpdateRequest;
use App\Http\Requests\Admin\Tools\Country\CountryCreateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CountryController extends Controller
{
    protected $countryService;
    protected $createCountry;
    protected $updateCountry;
    protected $deleteCountry;


    public function __construct(
        CountryService $countryService,
        Create $createCountry,
        Update $updateCountry,
        Delete $deleteCountry
    ) {
        $this->countryService = $countryService;
        $this->createCountry = $createCountry;
        $this->updateCountry = $updateCountry;
        $this->deleteCountry = $deleteCountry;
    }

    public function index(): View
    {
        $countries = $this->countryService->getAllCountries();
        return view('admin.tools.config.countries.index', [
            'countries' => $countries
        ]);
    }

    public function create(): View
    {
        return view('admin.tools.config.countries.create');
    }

    public function store(CountryCreateRequest $request): RedirectResponse
    {
        $created = $this->createCountry->execute($request->validated());
        return $created
                ? Redirect::route('panel.tools.config.countries')->with('success', 'Ülke başarılı bir şekilde oluşturuldu')
                : Redirect::back()->with('error', 'Ülke oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View
    {
        $country = $this->countryService->getCountryById($id);
        return view('admin.tools.config.countries.edit', [
            'country' => $country
        ]);
    }

    public function update(CountryUpdateRequest $request, $id): RedirectResponse
    {
        $updated = $this->updateCountry->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.tools.config.countries')->with('success', 'Ülke başarılı bir şekilde güncellendi.')
                : Redirect::back()->with('error', 'Ülke güncellenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->deleteCountry->execute($id);
        return $deleted
                ? Redirect::route('panel.tools.config.countries')->with('success', 'Ülke başarılı bir şekilde silindi.')
                : Redirect::back()->with('error', 'Ülke silinirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }
}
