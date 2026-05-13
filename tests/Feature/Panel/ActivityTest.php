<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('admin can view activity logs with paginator links', function () {
    $admin = User::factory()->admin()->create();

    activity('panel')
        ->causedBy($admin)
        ->performedOn($admin)
        ->event('created')
        ->log('Test activity record.');

    $this->actingAs($admin)
        ->get(route('panel.tools.activity'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/tools/activity/index')
            ->has('activities.data', 1)
            ->where('activities.data.0.subject_label', 'Kullanıcı')
            ->has('activities.links', 3)
            ->where('activities.total', 1)
            ->has('filters')
            ->has('users')
            ->where('subject_types.0.value', 'User')
            ->where('subject_types.0.label', 'Kullanıcı')
        );
});
