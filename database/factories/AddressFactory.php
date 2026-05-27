<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'address' => fake()->address(),
            'postal_code' => fake()->postcode(),
            'country_id' => null,
            'city_id' => null,
            'district_id' => null,
        ];
    }
}
