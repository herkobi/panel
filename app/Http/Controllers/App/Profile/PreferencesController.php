<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Profile\PreferencesUpdateRequest;
use App\Models\Language;
use App\Services\App\Profile\PreferencesService;
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

        return Inertia::render('app/profile/appearance', [
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

        return to_route('app.profile.appearance.edit')
            ->with('toast', ['type' => 'success', 'message' => __('Tercihler güncellendi.')]);
    }
}
