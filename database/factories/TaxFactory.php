<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tax>
 */
class TaxFactory extends Factory
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
            'title' => 'Katma Değer Vergisi',
            'code' => 'KDV',
            'value' => 20,
            'desc' => 'Katma Değer Vergisi',
            'country_id' => 1
        ];
    }
}
