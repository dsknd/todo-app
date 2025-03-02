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

    /**
     * 割り当てを行ったユーザーとの関連
     */
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }

    /**
     * 権限の割り当てを検証
     * 
     * @throws \InvalidArgumentException 割り当てが不正な場合
     */
    public function validate(): void
    {
        // プロジェクトロールが存在することを確認
        if (!$this->projectRole) {
            throw new \InvalidArgumentException('Project role does not exist');
        }

        // プロジェクト権限が存在することを確認
        if (!$this->projectPermission) {
            throw new \InvalidArgumentException('Project permission does not exist');
        }

        // 割り当てを行うユーザーが存在することを確認
        if (!$this->assigner) {
            throw new \InvalidArgumentException('Assigner does not exist');
        }

        // カスタム権限の場合、同じプロジェクト内での割り当てであることを確認
        if ($this->projectPermission->is_custom) {
            if ($this->projectRole->project_id !== $this->projectPermission->project_id) {
                throw new \InvalidArgumentException('Cannot assign custom permission from different project');
            }
        }
    }
}
