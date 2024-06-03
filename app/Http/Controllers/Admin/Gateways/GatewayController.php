<?php

namespace App\Http\Controllers\Admin\Gateways;

use App\Actions\Admin\Gateways\Payments;
use App\Actions\Admin\Gateways\Bac;
use App\Actions\Admin\Gateways\CreditCards;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GatewayController extends Controller
{

    private $getPayments;
    private $getBac;
    private $getCreditCards;

    public function __construct(
        Payments $getPayments,
        Bac $getBac,
        CreditCards $getCreditCards,
    ) {
        $this->getPayments = $getPayments;
        $this->getBac = $getBac;
        $this->getCreditCards = $getCreditCards;
    }
    public function bac(): View|RedirectResponse
    {
        if (!auth()->user()->can('gateway.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $gateways = $this->getBac->execute();
        $values = [];
        foreach ($gateways as $gateway) {
            if ($gateway->value) {
                $values[] = json_decode($gateway->value, true);
            }
        }
        $payments = $this->getPayments->execute();
        return view('admin.gateways.bac', [
            'gateways' => $gateways,
            'values' => $values,
            'payments' => $payments
        ]);
    }

    public function cc(): View|RedirectResponse
    {
        if (!auth()->user()->can('gateway.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $gateways = $this->getCreditCards->execute();
        $values = [];
        foreach ($gateways as $gateway) {
            if ($gateway->value) {
                $values[] = json_decode($gateway->value, true);
            }
        }
        $payments = $this->getPayments->execute();
        return view('admin.gateways.cc', [
            'gateways' => $gateways,
            'values' => $values,
            'payments' => $payments
        ]);
    }

}
