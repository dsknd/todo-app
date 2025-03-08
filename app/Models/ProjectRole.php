<?php

namespace App\Models;

use App\Casts\ProjectIdCast;
use App\Casts\UserIdCast;
use App\Casts\ProjectRoleNumberCast;
use App\Enums\ProjectRoleTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectRoleAssignment;
use App\Models\Project;
use App\Models\User;

class ProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'role_number',
        'user_id',
        'name',
        'description',
    ];

    /**
     * 複数代入可能な属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'project_id' => ProjectIdCast::class,
        'role_number' => ProjectRoleNumberCast::class,
        'user_id' => UserIdCast::class,
        'name' => 'string',
        'description' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        // プロジェクトごとのタスク番号を生成
        static::creating(function ($projectRole) {
            $projectRole->role_number = static::where('project_id', $projectRole->project_id)
                ->lockForUpdate()
                ->max('role_number') + 1 ?? 1;
        });
    }

    /**
     * 関連するプロジェクトを取得
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * このロールに関連付けられたプロジェクトメンバーを取得
     */
    public function projectMembers()
    {
        return $this->belongsToMany(User::class, 'project_role_assignments', 'project_role_id', 'user_id')
            ->using(ProjectRoleAssignment::class);
    }

    /**
     * このロールに関連付けられた権限を取得
     */
    public function projectPermissions()
    {
        return $this->belongsToMany(
            ProjectPermission::class,
            'project_permission_assignments',
            'project_role_id',
            'project_permission_id'
        );
    }

    /**
     * project_role_assignments テーブルとの1対多リレーションを定義
     */
    public function projectRoleAssignments()
    {
        return $this->hasMany(ProjectRoleAssignment::class, 'project_role_id');
    }

}
