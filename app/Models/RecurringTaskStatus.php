<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringTaskStatus extends Model
{
    protected $fillable = [
        'recurring_task_setting_id',
        'task_id',
        'occurrence_number',     // 何回目の実行か
        'scheduled_date',        // 予定日
        'actual_date',          // 実際の実行日
        'status',               // 状態（scheduled, completed, skipped, failed）
        'notes',                // 備考
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'datetime',
        'actual_date' => 'datetime',
        'occurrence_number' => 'integer',
    ];

    /**
     * 状態の定義
     */
    public const STATUS_SCHEDULED = 'scheduled';   // 予定
    public const STATUS_COMPLETED = 'completed';   // 完了
    public const STATUS_SKIPPED = 'skipped';      // スキップ
    public const STATUS_FAILED = 'failed';        // 失敗

    /**
     * 定期タスク設定との関連
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(RecurringTaskSetting::class, 'recurring_task_setting_id');
    }

    /**
     * タスクとの関連
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * 状態の一覧を取得
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_SCHEDULED => '予定',
            self::STATUS_COMPLETED => '完了',
            self::STATUS_SKIPPED => 'スキップ',
            self::STATUS_FAILED => '失敗',
        ];
    }

    /**
     * タスクを完了としてマーク
     */
    public function markAsCompleted(?string $notes = null): void
    {
        $this->status = self::STATUS_COMPLETED;
        $this->actual_date = now();
        
        if ($notes) {
            $this->notes = $notes;
        }

        $this->save();
    }

    /**
     * タスクをスキップとしてマーク
     */
    public function markAsSkipped(string $reason): void
    {
        $this->status = self::STATUS_SKIPPED;
        $this->actual_date = now();
        $this->notes = $reason;
        $this->save();
    }

    /**
     * タスクを失敗としてマーク
     */
    public function markAsFailed(string $reason): void
    {
        $this->status = self::STATUS_FAILED;
        $this->actual_date = now();
        $this->notes = $reason;
        $this->save();
    }

    /**
     * 遅延しているかどうかを判定
     */
    public function isDelayed(): bool
    {
        if ($this->status !== self::STATUS_SCHEDULED) {
            return false;
        }

        return now() > $this->scheduled_date;
    }

    /**
     * 遅延日数を取得
     */
    public function getDelayDays(): int
    {
        if (!$this->isDelayed()) {
            return 0;
        }

        return now()->diffInDays($this->scheduled_date);
    }

    /**
     * 完了しているかどうかを判定
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * スキップされたかどうかを判定
     */
    public function isSkipped(): bool
    {
        return $this->status === self::STATUS_SKIPPED;
    }

    /**
     * 失敗したかどうかを判定
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }
}
