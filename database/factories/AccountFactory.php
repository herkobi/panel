<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->company(),
            'address' => fake()->address(),
            'postal_code' => fake()->postcode(),
            'country_id' => null,
            'city_id' => null,
            'district_id' => null,
        ];
    }
}
