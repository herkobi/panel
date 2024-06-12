<?php

namespace App\Actions\Admin\Tools\AuthLogs;

use App\Services\Admin\Tools\AuthLogsService as Service;

class UserLogs
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
     * Tüm kullanıcılara ait işlemleri getirir.
     *
     * @return mixed Kullanıcılara ait işlem listesi
     */
    public function execute()
    {
        $logs = $this->postService->getUserLogs();
        return $logs;
    }
}
