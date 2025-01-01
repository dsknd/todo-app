<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTaskStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'status_id',
        'count',
    ];

    /**
     * プロジェクトとのリレーションを定義します。
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * タスクステータスとのリレーションを定義します。
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }
}
