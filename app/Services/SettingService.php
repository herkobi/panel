<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SettingService
{
    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return Cache::remember('settings.all', 3600, function () {
            return $this->repository->all();
        });
    }

    public function get($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return $this->repository->get($key) ?? $default;
        });
    }

    public function set($key, $value)
    {
        $this->repository->set($key, $value);
        $this->forgetCache($key);
    }

    public function uploadAndSetFile($key, UploadedFile $file, $directory)
    {
        $this->deleteFile($key, $directory);
        $fileName = $this->generateUniqueFileName($file);
        $file->storeAs("public/$directory", $fileName);

        $this->set($key, "$directory/$fileName");
    }

    private function deleteFile($key, $directory)
    {
        $filePath = $this->get($key);
        if ($filePath && Storage::exists("public/$filePath")) {
            Storage::delete("public/$filePath");
        }
    }

    private function generateUniqueFileName(UploadedFile $file): string
    {
        return Str::random(10) . '.' . $file->getClientOriginalExtension();
    }

    private function forgetCache($key)
    {
        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');
    }

    public function getFullPath($key)
    {
        $filePath = $this->get($key);
        if ($filePath && Storage::exists("public/$filePath")) {
            return Storage::url($filePath);
        }
        return asset('herkobi-favicon.png');
    }
}
