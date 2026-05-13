<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveLanguageRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\LanguageResource;
use App\Models\Language;
use App\Models\Setting;
use App\Services\Panel\Tools\Definitions\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function index(Request $request): Response
    {
        $languages = Language::query()
            ->orderBy('sort_order')
            ->orderBy('code')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/language/index', [
            'languages' => PaginatedResource::make($languages, LanguageResource::class, $request),
            'defaults' => [
                'default_language_code' => Setting::get('default_language_code'),
            ],
        ]);
    }

    public function deleted(Request $request): Response
    {
        $languages = Language::query()
            ->onlyTrashed()
            ->orderBy('sort_order')
            ->orderBy('code')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/language/deleted', [
            'languages' => PaginatedResource::make($languages, LanguageResource::class, $request),
        ]);
    }

    public function store(SaveLanguageRequest $request, LanguageService $service): RedirectResponse
    {
        $language = $service->create($request->validated(), $request->user());

        return to_route('panel.tools.definitions.languages.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$language->name} dili oluşturuldu.")]);
    }

    public function update(SaveLanguageRequest $request, Language $language, LanguageService $service): RedirectResponse
    {
        $service->update($language, $request->validated(), $request->user());

        return to_route('panel.tools.definitions.languages.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$language->name} dili güncellendi.")]);
    }

    public function destroy(Request $request, Language $language, LanguageService $service): RedirectResponse
    {
        $name = $language->name;

        $service->delete($language, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} dili silindi.")]);
    }

    public function status(Request $request, Language $language, LanguageService $service): RedirectResponse
    {
        $wasActive = $language->status === Status::Active;
        $wasActive
            ? $service->deactivate($language, $request->user())
            : $service->activate($language, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$language->name} dili {$action}.")]);
    }

    public function restore(Request $request, string $language, LanguageService $service): RedirectResponse
    {
        $model = Language::onlyTrashed()->findOrFail($language);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->name} dili geri alındı.")]);
    }

    public function forceDelete(Request $request, string $language, LanguageService $service): RedirectResponse
    {
        $model = Language::onlyTrashed()->findOrFail($language);

        $name = $model->name;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} dili tamamen silindi.")]);
    }
}
