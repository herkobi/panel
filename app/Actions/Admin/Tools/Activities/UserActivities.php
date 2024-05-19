<?php

namespace App\Actions\Admin\Tools\Activities;

use App\Services\Admin\Tools\ActivitiesService as Service;

class UserActivities
{
    protected $postService;

    /**
     * GetAll işlemi için gerekli Service bağımlılığı enjekte edilir.
     *
     * @param Service $postService
     */
    public function __construct(Service $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Tüm kullanıcı etkinliklerini getirir.
     *
     * @return mixed Kullanıcı etkinlikleri listesi
     */
    public function execute()
    {
        $activities = $this->postService->userActivities();
        return $activities;
    }
}
