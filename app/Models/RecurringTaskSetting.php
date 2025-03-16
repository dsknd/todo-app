<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurringTaskSetting extends Model
{
    protected $fillable = [
        'task_id',
        'frequency_type',       // 繰り返しの種類（daily, weekly, monthly, yearly）
        'frequency_value',      // 繰り返しの値（例：2週間ごとなら2）
        'weekdays',            // 週次の場合の曜日指定（JSON配列）
        'monthdays',           // 月次の場合の日付指定（JSON配列）
        'start_date',          // 繰り返し開始日
        'end_date',            // 繰り返し終了日（オプション）
        'max_occurrences',     // 最大繰り返し回数（オプション）
        'current_occurrence',   // 現在の繰り返し回数
        'last_generated_date', // 最後にタスクを生成した日
        'is_active',           // アクティブかどうか
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weekdays' => 'array',
        'monthdays' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'last_generated_date' => 'datetime',
        'max_occurrences' => 'integer',
        'current_occurrence' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * 繰り返しの種類定義
     */
    public const TYPE_DAILY = 'daily';     // 毎日
    public const TYPE_WEEKLY = 'weekly';   // 毎週
    public const TYPE_MONTHLY = 'monthly'; // 毎月
    public const TYPE_YEARLY = 'yearly';   // 毎年

    /**
     * タスクとの関連
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * 繰り返しステータスとの関連
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(RecurringTaskStatus::class);
    }

    /**
     * 繰り返しの種類一覧を取得
     */
    public static function getFrequencyTypes(): array
    {
        return [
            self::TYPE_DAILY => '毎日',
            self::TYPE_WEEKLY => '毎週',
            self::TYPE_MONTHLY => '毎月',
            self::TYPE_YEARLY => '毎年',
        ];
    }

    /**
     * 次回の実行日を計算
     */
    public function calculateNextDate(?Carbon $fromDate = null): ?Carbon
    {
        $fromDate = $fromDate ?? $this->last_generated_date ?? $this->start_date;
        if (!$fromDate) {
            return null;
        }

        $nextDate = match($this->frequency_type) {
            self::TYPE_DAILY => $this->calculateNextDailyDate($fromDate),
            self::TYPE_WEEKLY => $this->calculateNextWeeklyDate($fromDate),
            self::TYPE_MONTHLY => $this->calculateNextMonthlyDate($fromDate),
            self::TYPE_YEARLY => $this->calculateNextYearlyDate($fromDate),
            default => null,
        };

        // 終了日をチェック
        if ($nextDate && $this->end_date && $nextDate > $this->end_date) {
            return null;
        }

        // 最大繰り返し回数をチェック
        if ($nextDate && $this->max_occurrences && $this->current_occurrence >= $this->max_occurrences) {
            return null;
        }

        return $nextDate;
    }

    /**
     * 次回の日次実行日を計算
     */
    private function calculateNextDailyDate(Carbon $fromDate): Carbon
    {
        return $fromDate->copy()->addDays($this->frequency_value);
    }

    /**
     * 次回の週次実行日を計算
     */
    private function calculateNextWeeklyDate(Carbon $fromDate): Carbon
    {
        if (empty($this->weekdays)) {
            return $fromDate->copy()->addWeeks($this->frequency_value);
        }

        $nextDate = $fromDate->copy()->addDay();
        while (!in_array($nextDate->dayOfWeek, $this->weekdays)) {
            $nextDate->addDay();
        }

        return $nextDate;
    }

    /**
     * 次回の月次実行日を計算
     */
    private function calculateNextMonthlyDate(Carbon $fromDate): Carbon
    {
        if (empty($this->monthdays)) {
            return $fromDate->copy()->addMonths($this->frequency_value);
        }

        $nextDate = $fromDate->copy()->addDay();
        while (!in_array($nextDate->day, $this->monthdays)) {
            $nextDate->addDay();
            if ($nextDate->day === 1) {
                // 月が変わった場合は最初の指定日に設定
                $nextDate->day = min($this->monthdays);
            }
        }

        return $nextDate;
    }

    /**
     * 次回の年次実行日を計算
     */
    private function calculateNextYearlyDate(Carbon $fromDate): Carbon
    {
        return $fromDate->copy()->addYears($this->frequency_value);
    }

    /**
     * 次回のタスクを生成
     */
    public function generateNextTask(): ?Task
    {
        if (!$this->is_active) {
            return null;
        }

        $nextDate = $this->calculateNextDate();
        if (!$nextDate) {
            $this->is_active = false;
            $this->save();
            return null;
        }

        // 新しいタスクを作成
        $newTask = $this->task->replicate();
        $newTask->due_date = $nextDate;
        $newTask->save();

        // 繰り返し情報を更新
        $this->current_occurrence++;
        $this->last_generated_date = $nextDate;
        $this->save();

        // 繰り返しステータスを作成
        $this->statuses()->create([
            'task_id' => $newTask->id,
            'occurrence_number' => $this->current_occurrence,
            'scheduled_date' => $nextDate,
        ]);

        return $newTask;
    }
}