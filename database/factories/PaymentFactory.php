<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'EFT/Havale İle Ödeme Bilgileri',
            'code' => 'bac',
            'desc' => 'EFT/Havale ödeme almak için hesap bilgilerinizi bu bölümden tanımlayabilirsiniz.'
        ];
    }

    /**
     * Define a state for credit card payment.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forCreditCardPayment()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Kredi Kartı İle Ödeme Yöntemleri',
                'code' => 'cc',
                'desc' => 'Kredi kartı ile ödeme almak için gerekli servislere ait bilgilere bu bölümden erişebilirsiniz.'
            ];
        });
    }
}
