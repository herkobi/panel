<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<District>
 */
class DistrictFactory extends Factory
{
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'name' => fake()->citySuffix().' '.fake()->city(),
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
