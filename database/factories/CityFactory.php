<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'code' => fake()->unique()->numerify('##'),
            'name' => fake()->city(),
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
