<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskClosure extends Pivot
{
    protected $table = 'task_closures';

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'depth',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'depth' => 'integer',
    ];

    /**
     * 祖先タスクとの関連
     */
    public function ancestor(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'ancestor_id');
    }

    /**
     * 子孫タスクとの関連
     */
    public function descendant(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'descendant_id');
    }

    /**
     * 指定されたタスクの全祖先を取得
     * 
     * @param int $taskId タスクID
     * @return array<Task> 祖先タスクの配列（深さでソート）
     */
    public static function getAncestors(int $taskId): array
    {
        return static::where('descendant_id', $taskId)
            ->where('depth', '>', 0)
            ->orderBy('depth')
            ->with('ancestor')
            ->get()
            ->map(fn ($closure) => $closure->ancestor)
            ->all();
    }

    /**
     * 指定されたタスクの全子孫を取得
     * 
     * @param int $taskId タスクID
     * @return array<Task> 子孫タスクの配列（深さでソート）
     */
    public static function getDescendants(int $taskId): array
    {
        return static::where('ancestor_id', $taskId)
            ->where('depth', '>', 0)
            ->orderBy('depth')
            ->with('descendant')
            ->get()
            ->map(fn ($closure) => $closure->descendant)
            ->all();
    }

    /**
     * 指定されたタスクの直接の子を取得
     * 
     * @param int $taskId タスクID
     * @return array<Task> 子タスクの配列
     */
    public static function getChildren(int $taskId): array
    {
        return static::where('ancestor_id', $taskId)
            ->where('depth', 1)
            ->with('descendant')
            ->get()
            ->map(fn ($closure) => $closure->descendant)
            ->all();
    }

    /**
     * 指定されたタスクの直接の親を取得
     */
    public static function getParent(int $taskId): ?Task
    {
        $closure = static::where('descendant_id', $taskId)
            ->where('depth', 1)
            ->with('ancestor')
            ->first();

        return $closure ? $closure->ancestor : null;
    }

    /**
     * 指定されたタスクのルートタスクを取得
     */
    public static function getRootTask(int $taskId): ?Task
    {
        $closure = static::where('descendant_id', $taskId)
            ->orderByDesc('depth')
            ->with('ancestor')
            ->first();

        return $closure ? $closure->ancestor : null;
    }

    /**
     * 指定されたタスクのリーフタスク（子を持たないタスク）を取得
     * 
     * @param int $taskId タスクID
     * @return array<Task> リーフタスクの配列
     */
    public static function getLeafTasks(int $taskId): array
    {
        $descendants = static::where('ancestor_id', $taskId)
            ->with('descendant')
            ->get()
            ->pluck('descendant_id')
            ->unique()
            ->all();

        return Task::whereIn('id', $descendants)
            ->whereNotExists(function ($query) {
                $query->select('ancestor_id')
                    ->from('task_closures')
                    ->whereColumn('ancestor_id', 'tasks.id')
                    ->where('depth', 1);
            })
            ->get()
            ->all();
    }
}
