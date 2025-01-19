<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectRoleAssignment;

class ProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_role_type_id',
        'project_id',
        'created_by',
        'name',
        'description',
    ];

    /**
     * 関連するプロジェクトを取得
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * 関連するプロジェクトロールタイプを取得
     */
    public function projectRoleType()
    {
        return $this->belongsTo(ProjectRoleType::class, 'project_role_type_id');
    }

    /**
     * このロールに関連付けられたプロジェクトメンバーを取得
     */
    public function projectMembers()
    {
        return $this->belongsToMany(User::class, 'project_role_assignments', 'project_role_id', 'user_id')
            ->using(ProjectRoleAssignment::class);
    }

    //=========================================================================================
    // table: ProjectRole
    //-----------------------------------------------------------------------------------------
    // relationship: ProjectRole 1 --> * ProjectPermissionAssignment 1 --> * ProjectPermission
    //=========================================================================================

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
