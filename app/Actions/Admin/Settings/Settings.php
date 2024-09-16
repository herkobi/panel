<?php

namespace App\Actions\Admin\Settings;

use App\Events\Admin\Settings\Settings as Event;
use App\Services\SettingService as Service;
use App\Traits\AuthUser;
use Illuminate\Http\UploadedFile;

class Settings
{
    use AuthUser;

    protected $settingService;

    public function __construct(Service $settingService)
    {
        $this->settingService = $settingService;
        $this->initializeAuthUser();
    }

    public function execute(array $settings)
    {
        $oldSettings = $this->settingService->all()->toArray();
        $settings = $this->processFileUploads($settings);

        foreach ($settings as $key => $value) {
            $this->settingService->set($key, $value);
        }

        $newSettings = $this->settingService->all()->toArray();

        event(new Event($this->user, $oldSettings, $newSettings));
        return $settings;
    }

    private function processFileUploads(array $settings): array
    {
        if (isset($settings['logo']) && $settings['logo'] instanceof UploadedFile) {
            $this->settingService->uploadAndSetFile('logo', $settings['logo'], 'logo');
        } else {
            $settings['logo'] = $this->settingService->get('logo');
        }

        if (isset($settings['favicon']) && $settings['favicon'] instanceof UploadedFile) {
            $this->settingService->uploadAndSetFile('favicon', $settings['favicon'], 'favicon');
        } else {
            $settings['favicon'] = $this->settingService->get('favicon');
        }

        return $settings;
    }
}
