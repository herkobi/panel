<?php

namespace App\Http\Controllers\Admin\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gateways\Paytr\PaytrUpdateRequest;
use App\Actions\Admin\Gateways\Paytr\GetOne;
use App\Actions\Admin\Gateways\Paytr\Update;
use App\Actions\Admin\Gateways\Payments;
use App\Actions\Admin\Gateways\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PaytrController extends Controller
{

    private $getOne;
    private $update;
    private $payments;
    private $currencies;

    public function __construct(
        GetOne $getOne,
        Update $update,
        Payments $payments,
        Currency $currencies,
    ) {
        $this->getOne = $getOne;
        $this->update = $update;
        $this->payments = $payments;
        $this->currencies = $currencies;
    }

    public function edit($id): View
    {
        if (!auth()->user()->can('gateway.cc.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $paytr = $this->getOne->execute($id);
        $values = json_decode($paytr->value, true);
        $payments = $this->payments->execute();
        $currencies = $this->currencies->execute();

        return view('admin.gateways.paytr.edit', [
            'paytr' => $paytr,
            'values' => $values,
            'currencies' => $currencies,
            'payments' => $payments
        ]);
    }

    public function update(PaytrUpdateRequest $request, $id): RedirectResponse
    {
        if (!auth()->user()->can('gateway.cc.update')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($id, $request->validated());
        return $updated
                ? Redirect::route('panel.gateways.cc')->with('success', 'Paytr ödeme bilgileri başarılı bir şekilde güncellendi')
                : Redirect::back()->with('error', 'Paytr ödeme bilgileri güncellenirken bir sorun oluştu. Lütfen tekrar deneyiniz');
    }
}
