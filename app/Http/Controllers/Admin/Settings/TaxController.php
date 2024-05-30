<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Tax\TaxCreateRequest;
use App\Http\Requests\Admin\Settings\Tax\TaxUpdateRequest;
use App\Actions\Admin\Settings\Tax\Create;
use App\Actions\Admin\Settings\Tax\Update;
use App\Actions\Admin\Settings\Tax\Delete;
use App\Actions\Admin\Settings\Tax\GetAll;
use App\Actions\Admin\Settings\Tax\GetOne;
use App\Actions\Admin\Settings\Tax\Countries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TaxController extends Controller
{
    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;
    private $countries;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete,
        Countries $countries
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
        $this->countries = $countries;
    }

    public function index(): View
    {
        $taxes = $this->getAll->execute();
        return view('admin.settings.taxes.index', compact('taxes'));
    }

    public function create(): View
    {
        $countries = $this->countries->execute();
        return view('admin.settings.taxes.create', compact('countries'));
    }

    public function store(TaxCreateRequest $request): RedirectResponse
    {
        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.settings.taxes')->with('success', 'Vergi bilgisi başarılı bir şekilde eklendi')
                : Redirect::back()->with('error', 'Vergi bilgisi başarılı bir şekilde eklendi');
    }

    public function edit($id): View
    {
        $tax = $this->getOne->execute($id);
        $countries = $this->countries->execute();
        return view('admin.settings.taxes.edit', compact('tax', 'countries'));
    }

    public function update(TaxUpdateRequest $request, $id): RedirectResponse
    {
        $tax = $this->getOne->execute($id);
        $newStatus = $request->input('status');
        $oldStatus = $tax->status->value;

        if ($newStatus != $oldStatus && $this->isDefault($tax)) {
            return Redirect::back()->with('error', 'Seçili vergi oranı genel vergi oranı olarak tanımlı. Genel vergi oranının durumunu değiştiremezsiniz.');
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.settings.taxes')->with('success', 'Vergi bilgisi başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Vergi bilgisi başarılı bir şekilde güncellendi');
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.settings.taxes')->with('success', 'Vergi bilgisi başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Vergi bilgisi başarılı bir şekilde silindi');
    }

    private function isDefault($tax): bool
    {
        return config('panel.tax') === $tax->code;
    }
}
