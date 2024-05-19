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
        $payments = $this->payments->execute();
        $currencies = $this->currencies->execute();

        return view('admin.gateways.bac.create', [
            'currencies' => $currencies,
            'payments' => $payments
        ]);

    }

    public function store(BacCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde kayıt edildi');
    }

    public function edit($id): View
    {
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
        $this->update->execute($id, $request->validated());
        return Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde güncellendi');
    }

    public function destroy($id): RedirectResponse
    {
        $this->delete->execute($id);
        return Redirect::route('panel.gateways.bac')->with('success', 'Hesap bilgileri başarılı bir şekilde silindi');
    }
}
