<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function all()
    {
        return Setting::all()->pluck('value', 'key');
    }

    public function get($key)
    {
        return Setting::where('key', $key)->value('value');
    }

    public function set($key, $value)
    {
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
