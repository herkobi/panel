<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Profile\PreferencesUpdateRequest;
use App\Models\Language;
use App\Services\Panel\Profile\PreferencesService;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
    public function edit(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('panel/profile/appearance', [
            'languages' => Language::query()
                ->active()
                ->orderBy('sort_order')
                ->orderBy('code')
                ->get(['id', 'code', 'name', 'native_name']),
            'timezones' => collect(DateTimeZone::listIdentifiers())
                ->map(fn (string $timezone): array => [
                    'value' => $timezone,
                    'label' => $timezone,
                ])
                ->values(),
            'preferences' => [
                'locale' => $user->getAttribute('locale') ?? config('app.locale'),
                'timezone' => $user->timezone ?? config('app.timezone'),
            ],
        ]);
    }

    public function update(PreferencesUpdateRequest $request, PreferencesService $service): RedirectResponse
    {
        $user = $service->update($request->user(), $request->validated());

        $user->loadMissing('language');

        session([
            'locale' => $user->language?->code ?? $user->getAttribute('locale') ?? config('app.locale'),
            'timezone' => $user->timezone ?? config('app.timezone'),
        ]);

        return to_route('panel.profile.appearance.edit')
            ->with('toast', ['type' => 'success', 'message' => __('Tercihler güncellendi.')]);
    }
}
