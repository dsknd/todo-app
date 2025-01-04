<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomTaskCategory extends Model
{
    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = [
        'type_id',
        'project_id',
        'created_by',
    ];

    /**
     * カテゴリに関連するタスクタイプを取得します。
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TaskType::class);
    }

    /**
     * カテゴリに関連するプロジェクトを取得します。
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * カテゴリに関連するタスクカテゴリを取得します。
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class);
    }

    public function scopeWithTaskCategory($query, $categoryId = null)
    {
        return $query->select(
            'custom_task_categories.*',
            'task_categories.name',
            'task_categories.description',
        )->leftJoin('task_categories', function ($join) use ($categoryId) {
                $join->on('custom_task_categories.category_id', '=', 'task_categories.id');
                if ($categoryId) {
                    $join->where('custom_task_categories.category_id', $categoryId);
                }
        });
    }

    /**
     * プロジェクト固有のカスタムタスクカテゴリを取得します。
     */
    public function scopeWithProjectTaskCategories($query, $projectId = null)
    {
        $query->select('task_categories.*', 'custom_task_categories.type_id', 'custom_task_categories.project_id')
            ->leftJoin('custom_task_categories', function ($join) use ($projectId) {
                $join->on('task_categories.id', '=', 'custom_task_categories.category_id');

                // project_idが指定されている場合のみ条件を追加
                if ($projectId) {
                    $join->where('custom_task_categories.project_id', $projectId);
                }
            });

        return $query;
    }

    /**
     * スーパタイプ（TaskCategory）と結合するスコープ
     */
    public function scopeWithTaskCategories($query, $projectId = null)
    {
        return $query->select('custom_task_categories.*', 'task_categories.name', 'task_categories.description')
            ->join('task_categories', function ($join) use ($projectId) {
                $join->on('custom_task_categories.category_id', '=', 'task_categories.id');

                // project_idが指定されている場合のみ条件を追加
                if ($projectId) {
                    $join->where('custom_task_categories.project_id', $projectId);
                }
            });
    }

}
