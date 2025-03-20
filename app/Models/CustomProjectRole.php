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
    protected $keyType = 'integer';
    public $incrementing = false;
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
     * 関連するプロジェクトロールを取得
     */
    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'project_role_id');
    }
    
    /**
     * 関連するプロジェクトを取得
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
