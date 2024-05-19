<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Currency\CurrencyCreateRequest;
use App\Http\Requests\Admin\Settings\Currency\CurrencyUpdateRequest;
use App\Actions\Admin\Settings\Currency\Create;
use App\Actions\Admin\Settings\Currency\Update;
use App\Actions\Admin\Settings\Currency\Delete;
use App\Actions\Admin\Settings\Currency\GetAll;
use App\Actions\Admin\Settings\Currency\GetOne;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    private $getAll;
    private $getOne;
    private $create;
    private $update;
    private $delete;

    public function __construct(
        GetAll $getAll,
        GetOne $getOne,
        Create $create,
        Update $update,
        Delete $delete
    ) {
        $this->getAll = $getAll;
        $this->getOne = $getOne;
        $this->create = $create;
        $this->update = $update;
        $this->delete = $delete;
    }

    public function index(): View
    {
        $currencies = $this->getAll->execute();
        return view('admin.settings.currencies.index', compact('currencies'));
    }

    public function create(): View
    {
        return view('admin.settings.currencies.create');
    }

    public function store(CurrencyCreateRequest $request): RedirectResponse
    {
        $this->create->execute($request->validated());
        return redirect()->route('panel.settings.currencies')->with('success', __('Para birimi başarılı bir şekilde eklendi'));
    }

    public function edit($id): View
    {
        $currency = $this->getOne->execute($id);
        return view('admin.settings.currencies.edit', compact('currency'));
    }

    public function update(CurrencyUpdateRequest $request, $id): RedirectResponse
    {
        $currency = $this->getOne->execute($id);
        $newStatus = $request->input('status');
        $oldStatus = $currency->status->value;

        if ($newStatus != $oldStatus && $this->isDefault($currency)) {
            return redirect()->back()->with('error', __('Seçili para birimi genel olarak tanımlı. Genel para biriminin durumunu değiştiremezsiniz.'));
        }

        $this->update->execute($id, $request->validated());
        return redirect()->route('panel.settings.currencies')->with('success', __('Para birimi başarılı bir şekilde güncellendi'));
    }

    public function destroy($id): RedirectResponse
    {
        $currency = $this->getOne->execute($id);

        if ($this->isDefault($currency)) {
            return redirect()->back()->with('error', __('Seçili para birimi genel para birimi olarak tanımlı. Lütfen önce sistem ayarlarından bu değeri değiştiriniz.'));
        }

        if ($currency->gateways()->count() > 0) {
            return redirect()->back()->with('error', __('Bu para birimi bazı ödeme geçitleriyle ilişkilendirilmiş. Lütfen önce bu ilişkileri kaldırınız.'));
        }

        $this->delete->execute($id);
        return redirect()->route('panel.settings.currencies')->with('success', __('Para birimi başarılı bir şekilde silindi'));
    }

    private function isDefault($currency): bool
    {
        return config('panel.currency') === $currency->code;
    }

}
