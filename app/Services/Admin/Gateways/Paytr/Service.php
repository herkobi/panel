<?php

namespace App\Services\Admin\Gateways\Paytr;

use App\Services\Admin\BaseService;
use App\Models\Currency;
use App\Models\Gateway;
use Illuminate\Support\Collection;

class Service extends BaseService
{
    const PAYMENT_ID = 2;
    const CODE = 'paytr';

    public function __construct(Gateway $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if(($action === 'create') ||  ($action === 'update')) {
            $data["payment_id"] = self::PAYMENT_ID;
            $data["value"] = json_encode([
                'code' => self::CODE,
                'merchant_id' => $data["merchant_id"],
                'merchant_key' => $data["merchant_key"],
                'merchant_salt' => $data["merchant_salt"],
                'merchant_ok_url' => $data["merchant_ok_url"],
                'merchant_fail_url' => $data["merchant_fail_url"],
            ]);
        }

        return $data;
    }

}
