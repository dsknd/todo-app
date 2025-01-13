<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_role_type_id',
        'project_permission_id',
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
     * このロールに関連付けられたスコープを取得
     */
    public function scopes()
    {
        return $this->belongsToMany(Scope::class, 'project_role_scopes', 'project_role_id', 'scope_id');
    }

    /**
     * このロールに関連付けられたプロジェクトメンバーを取得
     */
    public function projectMembers()
    {
        return $this->belongsToMany(User::class, 'project_role_assignments', 'project_role_id', 'user_id')
                    ->using(ProjectRoleAssignment::class);
    }
}
