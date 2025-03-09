<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\ProjectRoleIdCast;

class CustomProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_role_id',
        'name',
        'description',
    ];

    protected $casts = [
        'project_role_id' => ProjectRoleIdCast::class,
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
