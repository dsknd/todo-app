<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProjectMember;
use App\Models\Category;
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

    public function projectInvitations():HasMany
    {
        return $this->hasMany(ProjectInvitation::class);
    }

    /**
     * プロジェクト作成者を取得します。
     */
    public function projectCreatedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // TODO: プロジェクトのカテゴリを取得

    /**
     * プロジェクトのステータスを取得します。
     */
    public function projectStatus():BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    /**
     * プロジェクトに参加しているユーザを取得します。
     */
    public function projectMembers():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id')
                    ->using(ProjectMember::class)
                    ->withPivot('joined_at');
    }

    /**
     * プロジェクトに関連するロールを取得します。
     */
    public function projectRoles():HasMany
    {
        return $this->hasMany(ProjectRole::class);
    }

    /**
     * プロジェクトに関連するタスクを取得します。
     */
    public function projectTasks():HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    /**
     * プロジェクトのステータス別にタスク数を取得します。
     */
    public function projectTaskStatistics():HasMany
    {
        return $this->hasMany(ProjectTaskStatistic::class, 'project_id', 'id');
    }

    /**
     * プロジェクトの詳細を取得します。
     */
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
