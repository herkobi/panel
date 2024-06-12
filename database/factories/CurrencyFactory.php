<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
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
            'title' => 'Türk Lirası',
            'symbol' => '₺',
            'symbol_location' => 'left_space',
            'thousand_sep' => '.',
            'decimal_sep' => ',',
            'decimal_number' => 2,
            'code' => 'TRY'
        ];
    }
}
