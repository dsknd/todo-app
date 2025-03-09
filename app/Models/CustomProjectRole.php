<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\ProjectRoleIdCast;
use App\Casts\ProjectIdCast;
use App\Casts\ProjectRoleNumberCast;

class CustomProjectRole extends Model
{
    use HasFactory;

    protected $table = 'custom_project_roles';
    protected $primaryKey = 'project_role_id';
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'role_number',
        'name',
        'description',
    ];

    protected $casts = [
        'project_role_id' => ProjectRoleIdCast::class,
        'project_id' => ProjectIdCast::class,
        'role_number' => ProjectRoleNumberCast::class,
        'name' => 'string',
        'description' => 'string',
    ];

    /**
     * 関連するプロジェクトロールを取得
     */
    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }
}
