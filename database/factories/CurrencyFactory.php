<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->currencyCode(),
            'name' => fake()->currencyCode(),
            'symbol' => fake()->randomElement(['₺', '$', '€', '£']),
            'decimal_places' => 2,
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
