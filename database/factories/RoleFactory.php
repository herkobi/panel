<?php

namespace Database\Factories;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Super Admin',
            'type' => UserType::ADMIN,
            'desc' => 'Süper yönetici rolü',
            'guard_name' => 'web'
        ];
    }

    /**
     * Define admin role.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function adminRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin',
                'type' => UserType::ADMIN,
                'desc' => 'Admin yönetici rolü',
                'guard_name' => 'web'
            ];
        });
    }

    /**
     * Define user role.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function userRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'User',
                'type' => UserType::USER,
                'desc' => 'Kullanıcı rolü',
                'guard_name' => 'web'
            ];
        });
    }

    /**
     * Define demo role.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function demoRole()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Demo',
                'type' => UserType::USER,
                'desc' => 'Kullanıcı rolü',
                'guard_name' => 'web'
            ];
        });
    }
}
