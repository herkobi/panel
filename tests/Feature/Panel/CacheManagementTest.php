<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Inertia\Testing\AssertableInertia as Assert;

test('admin can view cache management page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('panel.tools.cache'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/tools/cache/index')
        );
});

test('admin can clear individual cache types', function (array $case) {
    $admin = User::factory()->admin()->create();

    Artisan::shouldReceive('call')
        ->once()
        ->with($case['command'])
        ->andReturn(0);

    Artisan::shouldReceive('output')
        ->once()
        ->andReturn('');

    $this->actingAs($admin)
        ->post(route('panel.tools.cache.clear', ['type' => $case['type']]))
        ->assertSessionHasNoErrors()
        ->assertRedirect()
        ->assertSessionHas('toast.type', 'success');

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'cache',
        'event' => 'cleared',
        'causer_id' => $admin->id,
    ]);

    $activity = Activity::query()->where('log_name', 'cache')->firstOrFail();

    expect($activity->properties->get('type'))->toBe($case['type']);
})->with('cache clear commands');

test('admin can clear all caches', function () {
    $admin = User::factory()->admin()->create();

    Artisan::shouldReceive('call')
        ->once()
        ->with('optimize:clear')
        ->andReturn(0);

    $this->actingAs($admin)
        ->post(route('panel.tools.cache.clear', ['type' => 'all']))
        ->assertSessionHasNoErrors()
        ->assertRedirect()
        ->assertSessionHas('toast.type', 'success');

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'cache',
        'event' => 'cleared',
        'causer_id' => $admin->id,
    ]);

    $activity = Activity::query()->where('log_name', 'cache')->firstOrFail();

    expect($activity->properties->get('type'))->toBe('all');
});

dataset('cache clear commands', [
    'application' => [[
        'type' => 'application',
        'command' => 'cache:clear',
    ]],
    'config' => [[
        'type' => 'config',
        'command' => 'config:clear',
    ]],
    'route' => [[
        'type' => 'route',
        'command' => 'route:clear',
    ]],
    'view' => [[
        'type' => 'view',
        'command' => 'view:clear',
    ]],
    'event' => [[
        'type' => 'event',
        'command' => 'event:clear',
    ]],
    'compiled' => [[
        'type' => 'compiled',
        'command' => 'clear-compiled',
    ]],
]);
