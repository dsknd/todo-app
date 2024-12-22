<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'owner_id',
        'progress'
    ];

    /**
     * プロジェクトのステータスへのリレーション
     */
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    /**
     * プロジェクトのオーナーへのリレーション
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}