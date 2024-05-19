<?php

namespace App\Services\Admin\Gateways;

use App\Models\Currency;
use App\Services\Admin\BaseService;
use App\Models\Payment;
use App\Models\Gateway;
use App\Traits\HasDefaultPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Service extends BaseService
{

    use HasDefaultPagination;

    protected $paymentModel;
    protected $currencyModel;

    const BAC_PAYMENT_ID = 1;
    const CC_PAYMENT_ID = 2;

    public function __construct(Gateway $model, Payment $paymentModel, Currency $currencyModel)
    {
        $this->model = $model;
        $this->paymentModel = $paymentModel;
        $this->currencyModel = $currencyModel;
    }

    protected function prepareData(array $data, string $action = 'create'): array
    {
        return $data;
    }

    /**
     * EFT/Havale ile ödeme yöntemlerinin listesini getirir.
     *
     * @return LengthAwarePaginator
     */
    public function getBac(): LengthAwarePaginator
    {
        return $this->model->where('payment_id', self::BAC_PAYMENT_ID)->defaultPagination();
    }

    /**
     * Kredi kartı ile ödeme yöntemlerinin listesini getirir.
     *
     * @return Collection
     */
    public function getCreditCards(): LengthAwarePaginator
    {
        return $this->model->where('payment_id', self::CC_PAYMENT_ID)->defaultPagination();
    }

    /**
     * Ödeme sistemlerinin listesini getirir.
     *
     * @return Collection
     */
    public function getPayments(): Collection
    {
        return $this->paymentModel->all();
    }

    /**
     * Para birimlerinin listesini getirir.
     *
     * @return Collection
     */
    public function getCurrencies(): Collection
    {
        return $this->currencyModel->all();
    }
}
