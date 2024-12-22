<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    /**
     * ステータスに関連付けられたプロジェクト
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'project_status_id');
    }
}