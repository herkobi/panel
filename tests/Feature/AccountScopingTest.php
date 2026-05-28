<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\Address;

test('global scope filters BelongsToAccount models by the bound account', function () {
    // Seeder may have created member data already; measure relative to it.
    $baseline = Address::count();

    $a = Account::factory()->create();
    $b = Account::factory()->create();

    Address::factory()->create(['account_id' => $a->id]);
    Address::factory()->create(['account_id' => $b->id]);

    // No bound account (panel/seeder/job context) → no filtering.
    expect(Address::count())->toBe($baseline + 2);

    // Member context → only the bound account's records are visible.
    app()->instance('account.current', $a);
    expect(Address::count())->toBe(1)
        ->and(Address::first()->account_id)->toBe($a->id);

    app()->forgetInstance('account.current');
    expect(Address::count())->toBe($baseline + 2);
});

test('creating hook auto-fills account_id from the bound account', function () {
    $account = Account::factory()->create();

    app()->instance('account.current', $account);

    $address = Address::create(['address' => 'Otomatik adres']);

    expect($address->account_id)->toBe($account->id);

    app()->forgetInstance('account.current');
});

test('creating hook does not override an explicit account_id', function () {
    $bound = Account::factory()->create();
    $explicit = Account::factory()->create();

    app()->instance('account.current', $bound);

    $address = Address::create([
        'account_id' => $explicit->id,
        'address' => 'Açık adres',
    ]);

    expect($address->account_id)->toBe($explicit->id);

    app()->forgetInstance('account.current');
});
