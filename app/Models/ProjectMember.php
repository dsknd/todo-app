<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectMember extends Pivot
{
    protected $table = 'project_members';

    // timestampsを無効にする
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /**
     * プロジェクトとの関連
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * メンバー（ユーザー）との関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * プロジェクトロールの割り当てとの関連
     */
    public function roleAssignments(): HasMany
    {
        return $this->hasMany(ProjectRoleAssignment::class, 'user_id', 'user_id')
            ->where('project_id', $this->project_id);
    }

    /**
     * プロジェクトロールとの関連
     */
    public function roles()
    {
        return $this->belongsToMany(
            ProjectRole::class,
            'project_role_assignments',
            'user_id',
            'project_role_id'
        )->where('project_role_assignments.project_id', $this->project_id);
    }

    /**
     * メンバーが特定の権限を持っているかチェック
     */
    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('projectPermissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

    /**
     * メンバーが特定のロールを持っているかチェック
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()
            ->where('name', $roleName)
            ->exists();
    }

    /**
     * メンバーの権限一覧を取得
     * 
     * @return array<string>
     */
    public function getPermissions(): array
    {
        return $this->roles()
            ->with('projectPermissions')
            ->get()
            ->flatMap(fn ($role) => $role->projectPermissions->pluck('name'))
            ->unique()
            ->values()
            ->toArray();
    }
}
