<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status_id',
        'owner_id',
        'progress'
    ];

    /**
     * プロジェクトオーナ(作成者)を取得します。
     */
    public function owner():BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * プロジェクトのステータスを取得します。
     */
    public function status():BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }

    /**
     * プロジェクトに参加しているユーザを取得します。
     */
    public function members():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id')->withPivot('joined_at');
    }

    /**
     * プロジェクトに関連するロールを取得します。
     */
    public function roles():HasMany
    {
        return $this->hasMany(ProjectRole::class);
    }

    /**
     * プロジェクトに関連するタスクを取得します。
     */
    public function tasks():HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    /**
     * プロジェクトのステータス別にタスク数を取得します。
     */
    public function taskStatistics():HasMany
    {
        return $this->hasMany(ProjectTaskStatistic::class, 'project_id', 'id');
    }
}
