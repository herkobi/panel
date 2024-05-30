<?php

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'parent_id' => $this->faker->randomElement([0]),
            'name' => $this->faker->word,
            'desc' => $this->faker->sentence,
            'guard_name' => 'web'
        ];
    }
}
