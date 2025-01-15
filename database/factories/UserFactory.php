<?php

namespace Database\Factories;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
   protected static ?string $password;

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
           'created_by_name' => 'Owner'
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
               'created_by_name' => 'Owner'
           ];
       });
   }

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
               'created_by_name' => 'Owner'
           ];
       });
   }

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
               'created_by_name' => 'Owner'
           ];
       });
   }

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
               'created_by_name' => 'Owner'
           ];
       });
   }

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
               'created_by_name' => 'Owner'
           ];
       });
   }

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

   public function unverified(): static
   {
       return $this->state(fn (array $attributes) => [
           'email_verified_at' => null,
       ]);
   }
}
