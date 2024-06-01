<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('page.management') ||
               $user->hasPermissionTo('page.create') ||
               $user->hasPermissionTo('page.update') ||
               $user->hasPermissionTo('page.delete');
    }

    public function view(User $user, Page $page)
    {
        return $user->hasPermissionTo('page.management') ||
               $user->hasPermissionTo('page.create') ||
               $user->hasPermissionTo('page.update') ||
               $user->hasPermissionTo('page.delete');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('page.management') ||
               $user->hasPermissionTo('page.create');
    }

    public function update(User $user, Page $page)
    {
        return $user->hasPermissionTo('page.management') ||
               $user->hasPermissionTo('page.update');
    }

    public function delete(User $user, Page $page)
    {
        return $user->hasPermissionTo('page.management') ||
               $user->hasPermissionTo('page.delete');
    }
}
