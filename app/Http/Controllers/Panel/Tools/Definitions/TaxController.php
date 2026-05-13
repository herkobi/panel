<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Definitions;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Tools\Definitions\SaveTaxRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Definitions\TaxResource;
use App\Models\Setting;
use App\Models\Tax;
use App\Services\Panel\Tools\Definitions\TaxService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaxController extends Controller
{
    public function index(Request $request): Response
    {
        $taxes = Tax::query()
            ->orderBy('name')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/tax/index', [
            'taxes' => PaginatedResource::make($taxes, TaxResource::class, $request),
            'defaults' => [
                'default_tax_id' => Setting::get('default_tax_id'),
            ],
        ]);
    }

    public function deleted(Request $request): Response
    {
        $taxes = Tax::query()
            ->onlyTrashed()
            ->orderBy('name')
            ->paginate(50);

        return Inertia::render('panel/tools/definitions/tax/deleted', [
            'taxes' => PaginatedResource::make($taxes, TaxResource::class, $request),
        ]);
    }

    public function store(SaveTaxRequest $request, TaxService $service): RedirectResponse
    {
        $tax = $service->create($request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$tax->name} vergi oranı oluşturuldu.")]);
    }

    public function update(SaveTaxRequest $request, Tax $tax, TaxService $service): RedirectResponse
    {
        $service->update($tax, $request->validated(), $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$tax->name} vergi oranı güncellendi.")]);
    }

    public function destroy(Request $request, Tax $tax, TaxService $service): RedirectResponse
    {
        $name = $tax->name;

        $service->delete($tax, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} vergi oranı silindi.")]);
    }

    public function status(Request $request, Tax $tax, TaxService $service): RedirectResponse
    {
        $wasActive = $tax->status === Status::Active;
        $wasActive
            ? $service->deactivate($tax, $request->user())
            : $service->activate($tax, $request->user());

        $action = $wasActive ? 'pasifleştirildi' : 'aktifleştirildi';

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$tax->name} vergi oranı {$action}.")]);
    }

    public function restore(Request $request, string $tax, TaxService $service): RedirectResponse
    {
        $model = Tax::onlyTrashed()->findOrFail($tax);

        $service->restore($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$model->name} vergi oranı geri alındı.")]);
    }

    public function forceDelete(Request $request, string $tax, TaxService $service): RedirectResponse
    {
        $model = Tax::onlyTrashed()->findOrFail($tax);

        $name = $model->name;

        $service->forceDelete($model, $request->user());

        return back()
            ->with('toast', ['type' => 'success', 'message' => __("{$name} vergi oranı tamamen silindi.")]);
    }
}
