<?php

namespace App\Services\Admin\Settings\Settings;

use App\Services\Admin\BaseService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppService extends BaseService
{

    const KEY = 'app';

    protected $model;

    public function __construct(
        Setting $model
    )
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    public function appData()
    {
        $logo = Storage::exists('public/logo/' . config('panel.logo'))
            ? Storage::url('logo/' . config('panel.logo'))
            : asset('herkobi.png');

        $favicon = Storage::exists('public/favicon/' . config('panel.favicon'))
            ? Storage::url('favicon/' . config('panel.favicon'))
            : asset('herkobi-favicon.png');

        return [
            'logo' => $logo,
            'favicon' => $favicon
        ];
    }

    public function updateData(Request $request)
    {
        $data = [];

        $data['title'] = $request->input('title', config('panel.title'));
        $data['slogan'] = $request->input('slogan', config('panel.slogan'));
        $data['email'] = $request->input('email', config('panel.email'));

        if ($request->hasFile('logo')) {
            $this->uploadAndDeleteLogo($request, $data);
        } else {
            $data['logo'] = config('panel.logo');
        }

        if ($request->hasFile('favicon')) {
            $this->uploadAndDeleteFavicon($request, $data);
        } else {
            $data['favicon'] = config('panel.favicon');
        }

        $setting = $this->model->firstWhere('key', self::KEY)->update([
            'value' => json_encode($data),
        ]);

        return $setting;
    }

    protected function uploadAndDeleteLogo($request, array &$data)
    {
        if (Storage::exists('public/logo/' . config('panel.logo'))) {
            Storage::delete('public/logo/' . config('panel.logo'));
        }
        $logo_name = 'logo.' . $request->logo->extension();
        $request->logo->storeAs('public/logo', $logo_name);
        $data['logo'] = $logo_name;
    }

    protected function uploadAndDeleteFavicon($request, array &$data)
    {
        if (Storage::exists('public/favicon/' . config('panel.favicon'))) {
            Storage::delete('public/favicon/' . config('panel.favicon'));
        }
        $favicon_name = 'favicon.' . $request->favicon->extension();
        $request->favicon->storeAs('public/favicon', $favicon_name);
        $data['favicon'] = $favicon_name;
    }

}
