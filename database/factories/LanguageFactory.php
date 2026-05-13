<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Language>
 */
class LanguageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->languageCode(),
            'name' => fake()->languageCode(),
            'native_name' => fake()->languageCode(),
            'status' => Status::Active,
            'sort_order' => 0,
        ];
    }
}
