<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaskCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_personal',
        'is_project',
        'project_id',
        'created_by',
    ];

    /**
     * カスタムタスクカテゴリを取得します。
     */
    public function customCategory(): HasOne
    {
        return $this->hasOne(CustomTaskCategory::class);
    }

    /**
     * カテゴリを作成したユーザを取得します。
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * カテゴリに関連するタスクを取得します。
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
