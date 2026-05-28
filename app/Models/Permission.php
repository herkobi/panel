<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

#[Fillable(['name', 'guard_name', 'group', 'label'])]
class Permission extends SpatiePermission
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'uuid';
}
