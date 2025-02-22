<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'task_number',
        'user_id',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'priority_id',
        'category_id',
        'status_id',
        'is_recurring',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'planned_start_date' => 'datetime',
        'planned_end_date' => 'datetime',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'is_recurring' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // プロジェクトごとのタスク番号を生成
        static::creating(function ($task) {
            $task->task_number = static::where('project_id', $task->project_id)
                ->lockForUpdate()
                ->max('task_number') + 1 ?? 1;
        });
    }

    /**
     * 子タスクとの関連
     */
    public function childTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * タスクステータスとの関連
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    /**
     * カテゴリとの関連
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 作成者との関連
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * プロジェクトとの関連
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_tasks')
            ->using(ProjectTask::class)
            ->withPivot(['display_order', 'project_wbs_number', 'weight'])
            ->withTimestamps();
    }

    /**
     * このタスクが依存しているタスクとの関連
     */
    public function dependencies(): BelongsToMany
    {
        return $this->belongsToMany(
            Task::class,
            'task_dependencies',
            'dependent_task_id',
            'dependency_task_id'
        )->using(TaskDependency::class)
         ->withPivot(['dependency_type', 'lag_minutes'])
         ->withTimestamps();
    }

    /**
     * このタスクに依存しているタスクとの関連
     */
    public function dependents(): BelongsToMany
    {
        return $this->belongsToMany(
            Task::class,
            'task_dependencies',
            'dependency_task_id',
            'dependent_task_id'
        )->using(TaskDependency::class)
         ->withPivot(['dependency_type', 'lag_minutes'])
         ->withTimestamps();
    }

    /**
     * タスクの開始日を取得（計画または実績）
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->actual_start_date ?? $this->planned_start_date;
    }

    /**
     * タスクの終了日を取得（計画または実績）
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->actual_end_date ?? $this->planned_end_date;
    }

    /**
     * タスクが遅延しているかどうかを判定
     */
    public function isDelayed(): bool
    {
        if (!$this->planned_end_date) {
            return false;
        }

        if ($this->actual_end_date) {
            return $this->actual_end_date > $this->planned_end_date;
        }

        return now() > $this->planned_end_date;
    }

    /**
     * タスクの全階層パスを取得
     * 
     * @return array<Task> 親タスクから順に並んだ配列
     */
    public function getHierarchyPath(): array
    {
        $path = [$this];
        $current = $this;

        while ($current->parentTask) {
            $current = $current->parentTask;
            array_unshift($path, $current);
        }

        return $path;
    }

    /**
     * 優先度を取得
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }

    /**
     * コメントとの関連
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    /**
     * 定期タスク設定との関連
     */
    public function recurringSettings(): HasMany
    {
        return $this->hasMany(RecurringTaskSetting::class);
    }

    /**
     * タグとの関連
     */
    public function tags(): BelongsToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'tag_assignments')
            ->withTimestamps();
    }
}
