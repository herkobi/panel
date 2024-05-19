<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'status' => AccountStatus::ACTIVE,
            'type' => UserType::ADMIN,
            'name' => 'Panel',
            'surname' => 'User',
            'title' => 'Yönetici',
            'about' => 'Ana yönetici hesabı',
            'settings' => json_encode([
                'language' => config('panel.language'),
                'timezone' => config('panel.timezone'),
                'dateformat' => config('panel.dateformat'),
                'timeformat' => config('panel.timeformat'),
            ]),
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'terms' => true,
            'created_by' => 0,
            'created_by_name' => 'Owner'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
