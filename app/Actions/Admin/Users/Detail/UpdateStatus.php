<?php

namespace App\Actions\Admin\Users\Detail;

use App\Events\Admin\Users\Detail\UpdatedStatus;
use App\Services\Admin\Users\Detail as Service;

class UpdateStatus
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
     * Belirtilen kullanıcının durumunu değiştirme.
     *
     * @return mixed Durum değişikliği
     */
    public function execute($id, array $data)
    {
        $status = $this->postService->updateStatus($id, $data);
        event(new UpdatedStatus($status));
        return $status;
    }
}
