<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMilestone extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'due_date',
        'priority',
        'is_achieved',
        'progress',
        'parent_milestone_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'is_achieved' => 'boolean',
        'progress' => 'decimal:2',
        'priority' => 'integer',
    ];

    /**
     * プロジェクトとの関連
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 親マイルストーンとの関連
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProjectMilestone::class, 'parent_milestone_id');
    }

    /**
     * 子マイルストーンとの関連
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class, 'parent_milestone_id');
    }

    /**
     * タスクとの関連
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'milestone_tasks', 'milestone_id', 'task_id')
            ->withPivot(['display_order', 'weight'])
            ->withTimestamps();
    }

    /**
     * 依存されているマイルストーンとの関連
     */
    public function dependentMilestones(): BelongsToMany
    {
        return $this->belongsToMany(
            ProjectMilestone::class,
            'project_milestone_dependencies',
            'dependency_milestone_id',
            'dependent_milestone_id'
        )->withPivot(['dependency_type', 'lag_minutes'])
         ->withTimestamps();
    }

    /**
     * 依存しているマイルストーンとの関連
     */
    public function dependencyMilestones(): BelongsToMany
    {
        return $this->belongsToMany(
            ProjectMilestone::class,
            'project_milestone_dependencies',
            'dependent_milestone_id',
            'dependency_milestone_id'
        )->withPivot(['dependency_type', 'lag_minutes'])
         ->withTimestamps();
    }
}