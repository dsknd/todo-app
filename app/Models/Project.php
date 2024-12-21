<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'project_type_id'];

    // 種別を取得するリレーション
    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
}