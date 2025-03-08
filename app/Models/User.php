<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Models\ProjectRoleAssignment;
use App\Models\Permission;
use App\Models\ProjectPermissionAssignment;
use App\Casts\UserIdCast;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public mixed $participatedProjects;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => UserIdCast::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ユーザが所有するプロジェクトを取得します。
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    /**
     * ユーザが参加しているプロジェクトを取得します。
     */
    public function participatedProjects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Project::class,
            ProjectMember::class,
            'user_id',     // 中間テーブルのユーザーID
            'id',          // プロジェクトテーブルのID
            'id',          // ユーザーテーブルのID
            'project_id'   // 中間テーブルのプロジェクトID
        );
    }

    /**
     * ユーザーが属するプロジェクトメンバーシップ
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class, 'user_id');
    }

    /**
     * ユーザーが割り当てられているプロジェクトロール
     */
    public function projectRoles()
    {
        return $this->belongsToMany(
            ProjectRole::class,
            'project_role_assignments', // 中間テーブル
            'user_id',                  // 中間テーブル上のユーザーID
            'project_role_id'           // 中間テーブル上のプロジェクトロールID
        )
            ->using(ProjectRoleAssignment::class) // Pivot モデルの指定
            ->withTimestamps(); // タイムスタンプを扱う場合
    }


    /**
     * ユーザーが特定のプロジェクトに割り当てられているロールを取得します。
     */
    public function projectRolesForProject($projectId)
    {
        return $this->projectRoles()->where('project_roles.project_id', $projectId);
    }
}
