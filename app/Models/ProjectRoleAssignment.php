<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectRoleAssignment extends Pivot
{
    protected $table = 'project_role_assignments';

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'project_role_id',
        'assignee_id',
        'assigner_id',
        'assigned_at',
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
     * プロジェクトとの関連
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * プロジェクトロールとの関連
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }

    /**
     * 割り当てを行ったユーザーとの関連
     */
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }

    /**
     * プロジェクトメンバーとの関連
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(ProjectMember::class, 'project_id', 'project_id')
            ->where('assignee_id', $this->assigned_user_id);
    }
}
