<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Settings\SystemSettingsUpdateRequest;
use App\Actions\Admin\Settings\Settings\System\GetAll;
use App\Actions\Admin\Settings\Settings\System\Update;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SystemSettingsController extends Controller implements HasMiddleware
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

    /**
     * Sistem Ayarları
     */
    public function system(): View|RedirectResponse
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        return view('admin.settings.system.index', $this->getAll->execute());
    }

    /**
     * Sistem ayarları güncelleme
     */
    public function update(SystemSettingsUpdateRequest $request): RedirectResponse
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $updated = $this->update->execute($request, 'system');
        return $updated
                ? Redirect::back()->with('success', 'Sistem ayarları başarılı bir şekilde güncellendi.')
                : Redirect::route('panel.settings.system')->with('error', 'Sistem ayarları güncellenemedi.');
    }

    public static function middleware(): array
    {
        return [
            'role:Super Admin'
        ];
    }
}
