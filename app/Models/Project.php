<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'project_status_id',
        'member_count',
        'task_count',
        'created_by',
        'category_id',
    ];

    public function invitations():HasMany
    {
        return $this->hasMany(ProjectInvitation::class);
    }

    /**
     * プロジェクト作成者を取得します。
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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



    public function scopeWithDetail(Builder $query): Builder
    {
        return $query->select(
            'projects.id',
            'projects.name',
            'projects.description',
            'projects.start_date',
            'projects.end_date',
            'projects.member_count',
            'projects.task_count',
            'projects.created_by',
            'categories.name as category', // カテゴリ名
            'project_statuses.name as project_status' // プロジェクトステータス名
        )
            ->leftJoin('categories', 'projects.category_id', '=', 'categories.id')
            ->leftJoin('project_statuses', 'projects.project_status_id', '=', 'project_statuses.id');
    }
}
