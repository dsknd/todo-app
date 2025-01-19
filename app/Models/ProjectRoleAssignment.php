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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }
}
