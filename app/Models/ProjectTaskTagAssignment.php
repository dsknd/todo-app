<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectTaskTagAssignment extends Pivot
{
    protected $table = 'project_task_tag_assignments';

    public $incrementing = false;

    protected $fillable = [
        'project_task_tag_id',
        'project_task_id',
        'assigned_by',
    ];

    /**
     * タグとの関連
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(ProjectTaskTag::class, 'project_task_tag_id');
    }

    /**
     * タスクとの関連
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(ProjectTask::class);
    }

    /**
     * タグ付けを行ったユーザーとの関連
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
