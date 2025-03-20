<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\ProjectRoleIdCast;

class DefaultProjectRole extends Model
{
    use HasFactory;

    protected $table = 'default_project_roles';
    protected $primaryKey = 'project_role_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'key',
    ];

    protected $casts = [
        'project_role_id' => ProjectRoleIdCast::class,
        'key' => 'string',
    ];

    /**
     * 関連するプロジェクトロールを取得
     */
    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }
}
