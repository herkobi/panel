<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tax>
 */
class TaxFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'KDV %'.fake()->randomElement([1, 10, 20]),
            'rate' => fake()->randomFloat(2, 0, 20),
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
