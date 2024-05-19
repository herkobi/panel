<?php

namespace App\Services\Admin\Gateways\Bac;

use App\Services\Admin\BaseService;
use App\Models\Gateway;

class Service extends BaseService
{
    const PAYMENT_ID = 1;

    public function __construct(Gateway $model)
    {
        $this->model = $model;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        if(($action === 'create') ||  ($action === 'update')) {
            $data["payment_id"] = self::PAYMENT_ID;
            $data["value"] = json_encode([
                'account_name' => $data["account_name"],
                'account_bank' => $data["account_bank"],
                'account_code' => $data["account_code"],
                'account_number' => $data["account_number"],
                'account_iban' => $data["account_iban"],
                'account_swift' => $data["account_swift"],
            ]);
        }

        return $data;

    }

}
