<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectPermission extends Model
{
    protected $fillable = [
        'permission_id',
        'name',
        'description',
        'is_custom',      // カスタム権限かどうか
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_custom' => 'boolean',
    ];

    /**
     * 基本権限との関連
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * プロジェクトロールとの関連
     */
    public function projectRoles(): BelongsToMany
    {
        return $this->belongsToMany(
            ProjectRole::class,
            'project_permission_assignments',
            'project_permission_id',
            'project_role_id'
        )->withTimestamps();
    }

    /**
     * 権限の割り当てとの関連
     */
    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(
            ProjectRole::class,
            'project_permission_assignments',
            'project_permission_id',
            'project_role_id'
        )->withTimestamps();
    }

    /**
     * デフォルトの権限一覧を取得
     * 
     * @return array<self>
     */
    public static function getDefaults(): array
    {
        return static::where('is_custom', false)
            ->orderBy('name')
            ->get()
            ->all();
    }

    /**
     * カスタム権限一覧を取得
     * 
     * @return array<self>
     */
    public static function getCustoms(): array
    {
        return static::where('is_custom', true)
            ->orderBy('name')
            ->get()
            ->all();
    }

    /**
     * 指定されたロールに権限を割り当て
     */
    public function assignToRole(ProjectRole $role): void
    {
        if (!$this->projectRoles->contains($role->id)) {
            $this->projectRoles()->attach($role->id);
        }
    }

    /**
     * 指定されたロールから権限を削除
     */
    public function removeFromRole(ProjectRole $role): void
    {
        $this->projectRoles()->detach($role->id);
    }

    /**
     * 指定されたロールに権限が割り当てられているかチェック
     */
    public function isAssignedToRole(ProjectRole $role): bool
    {
        return $this->projectRoles->contains($role->id);
    }
}
