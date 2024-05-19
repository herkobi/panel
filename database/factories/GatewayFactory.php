<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gateway>
 */
class GatewayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'status' => Status::ACTIVE,
            'payment_id' => 1,
            'currency_id' => 1,
            'title' => 'Eft/Havale İle Ödeme',
            'desc' => 'Ödemenizi doğrudan banka hesabımıza yapınız. Lütfen ilgili Sipariş Numarasını ödemenizin açıklama kısmına yazınız. Ödemeniz onaylanmadıkça hesabınız askıda kalacaktır.',
            'value' => json_encode(
                [
                    'account_name' => '',
                    'account_bank' => '',
                    'account_code' => '',
                    'account_number' => '',
                    'account_iban' => '',
                    'account_swift' => ''
                ]
            )
        ];
    }

    /**
     * Define a state for credit card payment.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forCreditCardGateway()
    {

        return $this->state(function (array $attributes) {
            return [
                'status' => Status::PASSIVE,
                'payment_id' => 2,
                'currency_id' => 1,
                'title' => 'Banka/Kredi Kartı (PayTR) İle Ödeme',
                'desc' => 'Ödemenizi Paytr aracılığıyla kredi kartınızdan yapın.',
                'value' => json_encode(
                    [
                        'code' => 'paytr',
                        'merchant_id' => '',
                        'merchant_key' => '',
                        'merchant_salt' => '',
                        'merchant_ok_url' => env('APP_URL') .'/app/paytr-success',
                        'merchant_fail_url' => env('APP_URL') .'/app/paytr-error'
                    ]
                )
            ];
        });
    }
}
