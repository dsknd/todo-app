<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectPermissionAssignment extends Pivot
{
    protected $table = 'project_permission_assignments';
    
    public $timestamps = false;

    protected $fillable = [
        'project_role_id',
        'project_permission_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * プロジェクトロールとの関連
     */
    public function projectRole(): BelongsTo
    {
        return $this->belongsTo(ProjectRole::class);
    }

    /**
     * プロジェクト権限との関連
     */
    public function projectPermission(): BelongsTo
    {
        return $this->belongsTo(ProjectPermission::class);
    }
}
