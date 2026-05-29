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
            ->where('causer_types.0.value', 'admin')
            ->where('causer_types.0.label', 'Yönetici')
            ->where('causer_types.1.value', 'member')
            ->where('causer_types.1.label', 'Üye')
            ->where('subject_types.0.value', 'User')
            ->where('subject_types.0.label', 'Kullanıcı')
        );
});

test('activity logs can be filtered by causer user type', function () {
    $admin = User::factory()->admin()->create();
    $member = User::factory()->member()->create();

    activity('panel')->causedBy($admin)->performedOn($admin)->event('created')->log('Admin action.');
    activity('panel')->causedBy($member)->performedOn($member)->event('created')->log('Member action.');

    // Yönetici türü ile filtrelenince yalnızca admin'in eylemi gelmeli.
    $this->actingAs($admin)
        ->get(route('panel.tools.activity', ['causer_type' => 'admin']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('activities.data', 1)
            ->where('activities.data.0.causer.name', $admin->name)
        );

    // Üye türü ile filtrelenince yalnızca member'ın eylemi gelmeli.
    $this->actingAs($admin)
        ->get(route('panel.tools.activity', ['causer_type' => 'member']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('activities.data', 1)
            ->where('activities.data.0.causer.name', $member->name)
        );
});
