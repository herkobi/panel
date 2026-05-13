<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Database\Seeders\TurkiyeLocationsSeeder;

test('turkiye locations are seeded from embedded data', function () {
    $country = Country::query()->where('code', 'TR')->firstOrFail();

    expect(City::query()->whereBelongsTo($country)->count())->toBe(81)
        ->and(District::query()->count())->toBe(973);

    $istanbul = City::query()
        ->whereBelongsTo($country)
        ->where('code', '34')
        ->firstOrFail();

    expect($istanbul->name)->toBe('İstanbul')
        ->and(
            District::query()
                ->whereBelongsTo($istanbul)
                ->where('name', 'Kadıköy')
                ->exists()
        )->toBeTrue();
});

test('turkiye locations seeder is idempotent', function () {
    $this->seed(TurkiyeLocationsSeeder::class);
    $this->seed(TurkiyeLocationsSeeder::class);

    $country = Country::query()->where('code', 'TR')->firstOrFail();

    expect(City::query()->whereBelongsTo($country)->count())->toBe(81)
        ->and(District::query()->count())->toBe(973);
});
