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

    /**
     * ProjectPermission とのリレーション (belongsTo)
     */
    public function projectPermission()
    {
        return $this->belongsTo(ProjectPermission::class, 'project_permission_id');
    }

    /**
     * ProjectRole とのリレーション (belongsTo)
     */
    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }
}

