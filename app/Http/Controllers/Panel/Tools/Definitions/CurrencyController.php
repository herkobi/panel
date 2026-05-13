<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveCurrencyRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\CurrencyResource;
use App\Models\Currency;
use App\Models\Setting;
use App\Services\Panel\Tools\Definitions\CurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CurrencyController extends Controller
{
    public function index(Request $request): Response
    {
        $currencies = Currency::query()
            ->orderBy('sort_order')
            ->orderBy('code')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/currency/index', [
            'currencies' => PaginatedResource::make($currencies, CurrencyResource::class, $request),
            'defaults' => [
                'default_currency_id' => Setting::get('default_currency_id'),
            ],
        ]);
    }

    public function deleted(Request $request): Response
    {
        $currencies = Currency::query()
            ->onlyTrashed()
            ->orderBy('sort_order')
            ->orderBy('code')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/currency/deleted', [
            'currencies' => PaginatedResource::make($currencies, CurrencyResource::class, $request),
        ]);
    }

    public function store(SaveCurrencyRequest $request, CurrencyService $service): RedirectResponse
    {
        $currency = $service->create($request->validated(), $request->user());

        return to_route('panel.tools.definitions.currencies.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$currency->code} para birimi oluşturuldu.")]);
    }

    public function update(SaveCurrencyRequest $request, Currency $currency, CurrencyService $service): RedirectResponse
    {
        $service->update($currency, $request->validated(), $request->user());

        return to_route('panel.tools.definitions.currencies.index')
            ->with('toast', ['type' => 'success', 'message' => __("{$currency->code} para birimi güncellendi.")]);
    }

    public function destroy(Request $request, Currency $currency, CurrencyService $service): RedirectResponse
    {
        $code = $currency->code;

        $service->delete($currency, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$code} para birimi silindi.")]);
    }

    public function status(Request $request, Currency $currency, CurrencyService $service): RedirectResponse
    {
        $wasActive = $currency->status === Status::Active;
        $wasActive
            ? $service->deactivate($currency, $request->user())
            : $service->activate($currency, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$currency->code} para birimi {$action}.")]);
    }

    public function restore(Request $request, string $currency, CurrencyService $service): RedirectResponse
    {
        $model = Currency::onlyTrashed()->findOrFail($currency);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->code} para birimi geri alındı.")]);
    }

    public function forceDelete(Request $request, string $currency, CurrencyService $service): RedirectResponse
    {
        $model = Currency::onlyTrashed()->findOrFail($currency);

        $code = $model->code;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$code} para birimi tamamen silindi.")]);
    }
}
