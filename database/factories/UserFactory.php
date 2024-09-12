<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
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
            'type' => UserType::SUPER,
            'name' => 'Super',
            'surname' => 'User',
            'email' => 'super@super.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_by' => 0,
            'created_by_name' => 'Owner',
            'terms' => true
        ];
    }

    public function adminUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::ACTIVE,
                'type' => UserType::ADMIN,
                'name' => 'Admin',
                'surname' => 'User',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner',
                'terms' => true
            ];
        });
    }

    /**
     * Define normal user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function normalUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::ACTIVE,
                'type' => UserType::USER,
                'name' => 'Normal',
                'surname' => 'User',
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner',
                'terms' => true
            ];
        });
    }

    /**
     * Define draft user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function draftUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::DRAFT,
                'type' => UserType::USER,
                'name' => 'Draft',
                'surname' => 'User',
                'email' => 'draft@site.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner',
                'terms' => true
            ];
        });
    }

    /**
     * Define draft user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function passiveUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::PASSIVE,
                'type' => UserType::USER,
                'name' => 'Passive',
                'surname' => 'User',
                'email' => 'passive@user.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner',
                'terms' => true
            ];
        });
    }

    /**
     * Define deleted user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deletedUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::DELETED,
                'type' => UserType::USER,
                'name' => 'Deleted',
                'surname' => 'User',
                'email' => 'deleted@user.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner',
                'terms' => true
            ];
        });
    }

    /**
     * Define demo user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function demoUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AccountStatus::ACTIVE,
                'type' => UserType::DEMO,
                'name' => 'Demo',
                'surname' => 'User',
                'email' => 'demo@user.com',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_by' => 0,
                'created_by_name' => 'Owner'
            ];
        });
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
