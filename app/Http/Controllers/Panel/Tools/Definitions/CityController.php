<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveCityRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\CityResource;
use App\Http\Resources\Panel\Tools\Definitions\CountryResource;
use App\Models\City;
use App\Models\Country;
use App\Services\Panel\Tools\Definitions\CityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(Request $request, Country $country): Response
    {
        $cities = City::query()
            ->whereBelongsTo($country)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(100);

        return Inertia::render('panel/tools/definitions/city/index', [
            'cities' => PaginatedResource::make($cities, CityResource::class, $request),
            'country' => CountryResource::make($country),
        ]);
    }

    public function deleted(Request $request, Country $country): Response
    {
        $cities = City::query()
            ->onlyTrashed()
            ->whereBelongsTo($country)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(100);

        return Inertia::render('panel/tools/definitions/city/deleted', [
            'cities' => PaginatedResource::make($cities, CityResource::class, $request),
            'country' => CountryResource::make($country),
        ]);
    }

    public function store(SaveCityRequest $request, Country $country, CityService $service): RedirectResponse
    {
        $city = $service->create($request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$city->name} ili oluşturuldu.")]);
    }

    public function update(SaveCityRequest $request, Country $country, City $city, CityService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $service->update($city, $request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$city->name} ili güncellendi.")]);
    }

    public function destroy(Request $request, Country $country, City $city, CityService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $name = $city->name;

        $service->delete($city, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ili silindi.")]);
    }

    public function status(Request $request, Country $country, City $city, CityService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $wasActive = $city->status === Status::Active;
        $wasActive
            ? $service->deactivate($city, $request->user())
            : $service->activate($city, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$city->name} ili {$action}.")]);
    }

    public function restore(Request $request, Country $country, string $city, CityService $service): RedirectResponse
    {
        $model = City::onlyTrashed()
            ->whereBelongsTo($country)
            ->findOrFail($city);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->name} ili geri alındı.")]);
    }

    public function forceDelete(Request $request, Country $country, string $city, CityService $service): RedirectResponse
    {
        $model = City::onlyTrashed()
            ->whereBelongsTo($country)
            ->findOrFail($city);

        $name = $model->name;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ili tamamen silindi.")]);
    }
}
