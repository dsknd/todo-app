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
use App\Casts\ProjectRoleIdCast;
use App\Casts\ProjectRoleTypeIdCast;

class ProjectRole extends Model
{
    use HasFactory;

    protected $table = 'project_roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'project_role_type_id',
        'assignable_limit',
        'assigned_count',
    ];

    /**
     * 複数代入可能な属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => ProjectRoleIdCast::class,
        'project_role_type_id' => ProjectRoleTypeIdCast::class,
        'assignable_limit' => 'integer',
        'assigned_count' => 'integer',
    ];

    /**
     * 関連するプロジェクトロールタイプを取得
     */
    public function projectRoleType()
    {
        return $this->belongsTo(ProjectRoleType::class, 'project_role_type_id');
    }

    /**
     * 関連するデフォルトプロジェクトロールを取得
     */
    public function defaultProjectRole()
    {
        return $this->belongsTo(DefaultProjectRole::class, 'project_role_id');
    }

    /**
     * 関連するカスタムプロジェクトロールを取得
     */
    public function customProjectRole()
    {
        return $this->belongsTo(CustomProjectRole::class, 'project_role_id');
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
}
