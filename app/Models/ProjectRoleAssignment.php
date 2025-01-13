<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectRoleAssignment extends Pivot
{
    protected $table = 'project_role_assignments';
    protected $fillable = [
        'project_id',
        'user_id',
        'project_role_id',
    ];
}
