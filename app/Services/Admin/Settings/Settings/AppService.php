<?php

namespace App\Services\Admin\Settings\Settings;

use App\Services\Admin\BaseService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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

    public function updateData(array $data): Setting
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $this->uploadAndDeleteLogo($data['logo'], $data);
        } else {
            $data['logo'] = config('panel.logo');
        }

        if (isset($data['favicon']) && $data['favicon'] instanceof UploadedFile) {
            $this->uploadAndDeleteFavicon($data['favicon'], $data);
        } else {
            $data['favicon'] = config('panel.favicon');
        }

        $data['title'] = $data['title'] ?? config('panel.title');
        $data['slogan'] = $data['slogan'] ?? config('panel.slogan');
        $data['email'] = $data['email'] ?? config('panel.email');

        $value = json_encode($data);

        $setting = $this->model->firstWhere('key', self::KEY);
        $setting->update(['value' => $value]);

        $setting->type = $data['type'] ?? 'app';

        return $setting;
    }

    protected function uploadAndDeleteLogo(UploadedFile $logo, array &$data)
    {
        if (Storage::exists('public/logo/' . config('panel.logo'))) {
            Storage::delete('public/logo/' . config('panel.logo'));
        }
        $logo_name = 'logo.' . $logo->extension();
        $logo->storeAs('public/logo', $logo_name);
        $data['logo'] = $logo_name;
    }

    protected function uploadAndDeleteFavicon(UploadedFile $favicon, array &$data)
    {
        if (Storage::exists('public/favicon/' . config('panel.favicon'))) {
            Storage::delete('public/favicon/' . config('panel.favicon'));
        }
        $favicon_name = 'favicon.' . $favicon->extension();
        $favicon->storeAs('public/favicon', $favicon_name);
        $data['favicon'] = $favicon_name;
    }


}
