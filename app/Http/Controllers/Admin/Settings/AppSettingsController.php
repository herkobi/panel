<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Settings\AppSettingsUpdateRequest;
use App\Actions\Admin\Settings\Settings\App\GetAll;
use App\Actions\Admin\Settings\Settings\App\Update;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppSettingsController extends Controller
{

    private $getAll;
    private $update;

    public function __construct(
        GetAll $getAll,
        Update $update,

    ) {
        $this->getAll = $getAll;
        $this->update = $update;
    }

    public function app(): View
    {
        return view('admin.settings.app.index', $this->getAll->execute());
    }

    public function update(AppSettingsUpdateRequest $request): RedirectResponse
    {
        $updated = $this->update->execute($request->validated(), 'app');
        return $updated
                ? Redirect::back()->with('success', 'Uygulama bilgileri başarılı bir şekilde güncellendi.')
                : Redirect::route('panel.settings.system')->with('error', 'Uygulama bilgileri güncellenemedi.');
    }
}
