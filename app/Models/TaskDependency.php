<?php

namespace App\Models;

use App\Enums\DependencyTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskDependency extends Pivot
{
    protected $table = 'task_dependencies';

    public $incrementing = false;

    protected $fillable = [
        'dependent_task_id',
        'dependency_task_id',
        'dependency_type',
        'lag_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dependency_type' => DependencyTypes::class,
        'lag_minutes' => 'integer',
    ];

    /**
     * 依存する側のタスクとの関連
     */
    public function dependentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'dependent_task_id');
    }

    /**
     * 依存される側のタスクとの関連
     */
    public function dependencyTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'dependency_task_id');
    }
    
    /**
     * 依存関係の検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        // 同じタスク同士の依存は不可
        if ($this->dependent_task_id === $this->dependency_task_id) {
            throw new \InvalidArgumentException('Cannot create dependency between same task');
        }

        // 循環参照のチェック
        if ($this->wouldCreateCycle()) {
            throw new \InvalidArgumentException('Circular dependency detected');
        }
    }

    /**
     * 循環参照をチェック
     */
    public function wouldCreateCycle(): bool
    {
        return $this->checkCycle($this->dependent_task_id, [$this->dependency_task_id]);
    }

    /**
     * 再帰的に循環参照をチェック
     * 
     * @param int $taskId チェック対象のタスクID
     * @param array<int> $visited 探索済みのタスクID配列
     */
    private function checkCycle(int $taskId, array $visited): bool
    {
        // 既に探索済みのタスクに戻ってきた場合は循環あり
        if (in_array($taskId, $visited)) {
            return true;
        }

        // このタスクが依存しているタスクを取得
        $dependencies = static::where('dependent_task_id', $taskId)
            ->pluck('dependency_task_id')
            ->toArray();

        // 依存先がない場合は循環なし
        if (empty($dependencies)) {
            return false;
        }

        // 探索済みリストに現在のタスクを追加
        $visited[] = $taskId;

        // 各依存先について再帰的にチェック
        foreach ($dependencies as $dependencyId) {
            if ($this->checkCycle($dependencyId, $visited)) {
                return true;
            }
        }

        return false;
    }

    /**
     * ラグ時間を分単位で設定
     */
    public function setLagMinutes(int $minutes): void
    {
        $this->lag_minutes = $minutes;
        $this->save();
    }

    /**
     * ラグ時間を時間単位で設定
     */
    public function setLagHours(float $hours): void
    {
        $this->lag_minutes = (int)($hours * 60);
        $this->save();
    }

    /**
     * ラグ時間を日単位で設定
     */
    public function setLagDays(float $days): void
    {
        $this->lag_minutes = (int)($days * 24 * 60);
        $this->save();
    }

    /**
     * ラグ時間を時間単位で取得
     */
    public function getLagHours(): float
    {
        return $this->lag_minutes / 60;
    }

    /**
     * ラグ時間を日単位で取得
     */
    public function getLagDays(): float
    {
        return $this->lag_minutes / (24 * 60);
    }
}