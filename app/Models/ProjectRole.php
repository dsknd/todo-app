<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
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
     * このロールに関連付けられたスコープを取得
     */
    public function scopes()
    {
        return $this->belongsToMany(Scope::class, 'project_role_scopes', 'project_role_id', 'scope_id');
    }
}
