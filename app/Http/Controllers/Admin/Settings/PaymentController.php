<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Settings\Payment\GetAll;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class PaymentController extends Controller
{

    private $getAll;

    public function __construct(
        GetAll $getAll,
    ) {
        $this->getAll = $getAll;
    }

    public function index(): View
    {
        if (!auth()->user()->can('gateway.management')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $payments = $this->getAll->execute();
        return view('admin.settings.payments.index', [
            'payments' => $payments
        ]);
    }
}
