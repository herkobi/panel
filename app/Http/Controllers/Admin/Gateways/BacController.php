<?php

namespace App\Http\Controllers\Admin\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gateways\Bac\BacCreateRequest;
use App\Http\Requests\Admin\Gateways\Bac\BacUpdateRequest;
use App\Actions\Admin\Gateways\Bac\GetOne;
use App\Actions\Admin\Gateways\Bac\Create;
use App\Actions\Admin\Gateways\Bac\Update;
use App\Actions\Admin\Gateways\Bac\Delete;
use App\Actions\Admin\Gateways\Payments;
use App\Actions\Admin\Gateways\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BacController extends Controller
{

    private $getOne;
    private $create;
    private $update;
    private $delete;
    private $payments;
    private $currencies;

    public function __construct(
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete,
        Payments $payments,
        Currency $currencies,
    ) {
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
        $this->payments = $payments;
        $this->currencies = $currencies;
    }

    public function create(): View
    {
        if (!auth()->user()->can('gateway.bac.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $payments = $this->payments->execute();
        $currencies = $this->currencies->execute();

        return view('admin.gateways.bac.create', [
            'currencies' => $currencies,
            'payments' => $payments
        ]);

    }

    public function store(BacCreateRequest $request): RedirectResponse
    {
        if (!auth()->user()->can('gateway.bac.create')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $created = $this->create->execute($request->validated());
        return $created
                ? Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde kayıt edildi')
                : Redirect::back()->with('error', 'Hesap bilgisi eklenirken bir sorun oluştu. Lütfen tekrar deneyiniz.');
    }

    public function edit($id): View
    {
        if (!auth()->user()->can('gateway.bac.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $bac = $this->getOne->execute($id);
        $values = json_decode($bac->value, true);
        $currencies = $this->currencies->execute();
        $payments = $this->payments->execute();

        return view('admin.gateways.bac.edit', [
            'bac' => $bac,
            'values' => $values,
            'currencies' => $currencies,
            'payments' => $payments
        ]);
    }

    public function update(BacUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('gateway.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Güncelleme yapılırken bir sorun oluştu, lütfen tekrar deneyiniz.');
    }

    public function destroy($id): RedirectResponse
    {
        if (!auth()->user()->can('gateway.bac.delete')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $deleted = $this->delete->execute($id);
        return $deleted
                ? Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde silindi')
                : Redirect::back()->with('error', 'Silme işlemi gerçekleşirken bir sorun oluştu, lütfen tekrar deneyiniz.');
    }
}
