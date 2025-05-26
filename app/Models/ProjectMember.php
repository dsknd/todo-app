<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Casts\ProjectIdCast;
use App\Casts\UserIdCast;
use App\Casts\ProjectRoleIdCast;
use App\Casts\ProjectMemberCreatedAtCast;

class ProjectMember extends Pivot
{
    use HasFactory;
    
    /**
     * テーブル名
     */
    protected $table = 'project_members';

    /**
     * タイムスタンプを有効にする
     */
    public $timestamps = true;

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'role_id',
        'joined_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'project_id' => ProjectIdCast::class,
        'user_id' => UserIdCast::class,
        'role_id' => ProjectRoleIdCast::class,
        'joined_at' => 'datetime',
        'created_at' => ProjectMemberCreatedAtCast::class,
        'updated_at' => 'datetime',
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
     * プロジェクトロールとの関連
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(ProjectRole::class, 'role_id');
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
