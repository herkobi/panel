<?php

namespace App\Actions\Admin\Tools\Activities;

use App\Services\Admin\Tools\ActivitiesService as Service;

class AccountActivities
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
     * Tüm hesap etkinliklerini getirir.
     *
     * @return mixed Hesap etkinlikleri listesi
     */
    public function execute()
    {
        $activities = $this->postService->accountActivities();
        return $activities;
    }
}
