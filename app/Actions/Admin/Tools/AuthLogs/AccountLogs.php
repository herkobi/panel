<?php

namespace App\Actions\Admin\Tools\AuthLogs;

use App\Services\Admin\Tools\AuthLogsService as Service;

class AccountLogs
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
     * Tüm oturum kayıtlarını getirir.
     *
     * @return mixed Oturum kayıtları listesi
     */
    public function execute()
    {
        $logs = $this->postService->getAccountLogs();
        return $logs;
    }
}
