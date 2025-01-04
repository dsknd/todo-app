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
        'is_custom',
    ];

    /**
     * カスタムタスクカテゴリを取得します。
     */
    public function customCategory(): HasOne
    {
        return $this->hasOne(CustomTaskCategory::class, 'category_id', 'id');
    }

    public function scopeWithCustomCategory($query, $categoryId = null)
    {
        return $query->select('task_categories.*', 'custom_task_categories.type_id', 'custom_task_categories.project_id')
            ->join('custom_task_categories', function ($join) use ($categoryId) {
                $join->on('task_categories.id', '=', 'custom_task_categories.category_id');
                if($categoryId) {
                    $join->where('custom_task_categories.category_id', $categoryId);
                }
            });
    }

    /**
     * カテゴリに関連するタスクを取得します。
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
