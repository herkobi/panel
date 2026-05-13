<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->countryCode(),
            'name' => fake()->country(),
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
