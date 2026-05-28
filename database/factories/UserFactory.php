<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

/**
 * @extends Factory<User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => UserStatus::Active,
            'user_type' => UserType::Member,
            'locale' => 'tr',
            'timezone' => 'Europe/Istanbul',
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
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

    /**
     * Test ortamında "admin" = panele erişebilen kullanıcı. Gate::before ile
     * Super Admin tüm yetkilere otomatik geçer; bu yüzden testlerde admin'i
     * Super Admin rolüyle yaratıyoruz. Üretimde admin@admin.com seeder ile
     * Super Admin atanır, diğer adminler UI'dan kurulurken rol verilir.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => UserType::Admin,
        ])->afterCreating(function (User $user): void {
            $role = Role::query()->firstOrCreate([
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]);

            $user->syncRoles([$role]);
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }

    /**
     * `admin()` için açık takma ad — okunaklı olması için.
     */
    public function superAdmin(): static
    {
        return $this->admin();
    }

    public function withRole(string $roleName): static
    {
        return $this->afterCreating(function (User $user) use ($roleName): void {
            $role = Role::query()->firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $user->syncRoles([$role]);
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }

    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_type' => UserType::Member,
        ]);
    }

    public function passive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Passive,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatus::Draft,
        ]);
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }
}
