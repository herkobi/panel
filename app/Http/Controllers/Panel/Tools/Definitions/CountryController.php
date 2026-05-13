<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveCountryRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\CountryResource;
use App\Models\Country;
use App\Models\Setting;
use App\Services\Panel\Tools\Definitions\CountryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function index(Request $request): Response
    {
        $countries = Country::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/country/index', [
            'countries' => PaginatedResource::make($countries, CountryResource::class, $request),
            'defaults' => [
                'default_country_id' => Setting::get('default_country_id'),
            ],
        ]);
    }

    public function deleted(Request $request): Response
    {
        $countries = Country::query()
            ->onlyTrashed()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/country/deleted', [
            'countries' => PaginatedResource::make($countries, CountryResource::class, $request),
        ]);
    }

    public function store(SaveCountryRequest $request, CountryService $service): RedirectResponse
    {
        $country = $service->create($request->validated(), $request->user());

        return to_route('panel.tools.definitions.countries.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$country->name} ülkesi oluşturuldu.")]);
    }

    public function update(SaveCountryRequest $request, Country $country, CountryService $service): RedirectResponse
    {
        $service->update($country, $request->validated(), $request->user());

        return to_route('panel.tools.definitions.countries.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$country->name} ülkesi güncellendi.")]);
    }

    public function destroy(Request $request, Country $country, CountryService $service): RedirectResponse
    {
        $name = $country->name;

        $service->delete($country, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ülkesi silindi.")]);
    }

    public function status(Request $request, Country $country, CountryService $service): RedirectResponse
    {
        $wasActive = $country->status === Status::Active;
        $wasActive
            ? $service->deactivate($country, $request->user())
            : $service->activate($country, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$country->name} ülkesi {$action}.")]);
    }

    public function restore(Request $request, string $country, CountryService $service): RedirectResponse
    {
        $model = Country::onlyTrashed()->findOrFail($country);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->name} ülkesi geri alındı.")]);
    }

    public function forceDelete(Request $request, string $country, CountryService $service): RedirectResponse
    {
        $model = Country::onlyTrashed()->findOrFail($country);

        $name = $model->name;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ülkesi tamamen silindi.")]);
    }
}
