<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveDistrictRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\CityResource;
use App\Http\Resources\Panel\Tools\Definitions\CountryResource;
use App\Http\Resources\Panel\Tools\Definitions\DistrictResource;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Services\Panel\Tools\Definitions\DistrictService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DistrictController extends Controller
{
    public function index(Request $request, Country $country, City $city): Response
    {
        abort_unless($city->country_id === $country->id, 404);

        $districts = District::query()
            ->whereBelongsTo($city)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(200);

        return Inertia::render('panel/tools/definitions/district/index', [
            'districts' => PaginatedResource::make($districts, DistrictResource::class, $request),
            'country' => CountryResource::make($country),
            'city' => CityResource::make($city),
        ]);
    }

    public function deleted(Request $request, Country $country, City $city): Response
    {
        abort_unless($city->country_id === $country->id, 404);

        $districts = District::query()
            ->onlyTrashed()
            ->whereBelongsTo($city)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(200);

        return Inertia::render('panel/tools/definitions/district/deleted', [
            'districts' => PaginatedResource::make($districts, DistrictResource::class, $request),
            'country' => CountryResource::make($country),
            'city' => CityResource::make($city),
        ]);
    }

    public function store(SaveDistrictRequest $request, Country $country, City $city, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $district = $service->create($request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$district->name} ilçesi oluşturuldu.")]);
    }

    public function update(SaveDistrictRequest $request, Country $country, City $city, District $district, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id && $district->city_id === $city->id, 404);

        $service->update($district, $request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$district->name} ilçesi güncellendi.")]);
    }

    public function destroy(Request $request, Country $country, City $city, District $district, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id && $district->city_id === $city->id, 404);

        $name = $district->name;

        $service->delete($district, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ilçesi silindi.")]);
    }

    public function status(Request $request, Country $country, City $city, District $district, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id && $district->city_id === $city->id, 404);

        $wasActive = $district->status === Status::Active;
        $wasActive
            ? $service->deactivate($district, $request->user())
            : $service->activate($district, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$district->name} ilçesi {$action}.")]);
    }

    public function restore(Request $request, Country $country, City $city, string $district, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $model = District::onlyTrashed()
            ->whereBelongsTo($city)
            ->findOrFail($district);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->name} ilçesi geri alındı.")]);
    }

    public function forceDelete(Request $request, Country $country, City $city, string $district, DistrictService $service): RedirectResponse
    {
        abort_unless($city->country_id === $country->id, 404);

        $model = District::onlyTrashed()
            ->whereBelongsTo($city)
            ->findOrFail($district);

        $name = $model->name;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} ilçesi tamamen silindi.")]);
    }
}
