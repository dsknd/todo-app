<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Casts\ProjectRoleIdCast;
use App\Casts\PermissionIdCast;

class ProjectRolePermission extends Pivot
{
    use HasFactory;

    protected $table = 'project_role_permissions';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'project_role_id',
        'project_permission_id',
        'assigned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'project_role_id' => ProjectRoleIdCast::class,
        'project_permission_id' => PermissionIdCast::class,
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
