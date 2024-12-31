<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProjectStatus;
use App\Models\ProjectMember;

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

    /**
     * プロジェクトに関連付けられたメンバー
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->using(ProjectMember::class); // カスタムPivotクラスを使用
    }

    /**
     * プロジェクトに関連付けられたロール
     */
    public function roles()
    {
        return $this->hasMany(ProjectRole::class, 'project_id');
    }
}