<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectPermissionAssignment extends Pivot
{
    protected $table = 'project_permission_assignments';
    protected $fillable = [
        'project_permission_id',
        'project_role_id',
    ];
}

