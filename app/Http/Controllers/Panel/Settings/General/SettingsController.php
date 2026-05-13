<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Settings\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Settings\General\UpdateSettingsRequest;
use App\Http\Resources\Panel\Tools\Definitions\CountryResource;
use App\Http\Resources\Panel\Tools\Definitions\CurrencyResource;
use App\Http\Resources\Panel\Tools\Definitions\LanguageResource;
use App\Http\Resources\Panel\Tools\Definitions\TaxResource;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Tax;
use App\Services\Panel\Settings\General\SettingsService;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function edit(SettingsService $service): Response
    {
        return Inertia::render('panel/settings/general/index', [
            'settings' => $service->all(),
            'countries' => CountryResource::collection(
                Country::query()->active()->orderBy('name')->get()
            ),
            'currencies' => CurrencyResource::collection(
                Currency::query()->active()->orderBy('sort_order')->orderBy('name')->get()
            ),
            'taxes' => TaxResource::collection(
                Tax::query()->active()->orderBy('name')->get()
            ),
            'languages' => LanguageResource::collection(
                Language::query()->active()->orderBy('sort_order')->orderBy('name')->get()
            ),
            'timezones' => DateTimeZone::listIdentifiers(),
        ]);
    }

    public function update(UpdateSettingsRequest $request, SettingsService $service): RedirectResponse
    {
        $service->update($request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __('Ayarlar güncellendi.')]);
    }
}
