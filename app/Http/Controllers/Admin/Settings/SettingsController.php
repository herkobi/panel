<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Actions\Admin\Settings\Settings as SettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Settings\SettingsUpdateRequest;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingsController extends Controller
{
    protected $settingService;
    protected $updateSettingsAction;

    public function __construct(SettingService $settingService, SettingsAction $updateSettingsAction)
    {
        $this->settingService = $settingService;
        $this->updateSettingsAction = $updateSettingsAction;
    }

    public function index(): View
    {
        $settings = $this->settingService->all();
        return view('admin.settings.system.index', [
            'settings' => $settings
        ]);
    }

    public function update(SettingsUpdateRequest $request): RedirectResponse
    {
        $updated = $this->updateSettingsAction->execute($request->validated());
        return $updated
            ? Redirect::route('panel.settings.general')->with('success', 'Uygulama bilgileri başarılı bir şekilde güncellendi.')
            : Redirect::route('panel.settings.general')->with('error', 'Uygulama bilgileri güncellenirken bir hata oluştu. Lütfen tekrar deneyiniz.');
    }
}
