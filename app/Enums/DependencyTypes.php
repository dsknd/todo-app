<?php

namespace App\Enums;

enum DependencyTypes: string
{
    case FINISH_TO_START = 'FS';  // 先行タスクが終了後に後続タスクを開始（標準的な依存関係）
    case START_TO_START = 'SS';   // 先行タスクの開始と同時に後続タスクを開始
    case FINISH_TO_FINISH = 'FF'; // 先行タスクの終了と同時に後続タスクを終了
    case START_TO_FINISH = 'SF';  // 先行タスクの開始後に後続タスクを終了（稀なケース）

    /**
     * 依存タイプの説明を取得
     */
    public function getDescription(): string
    {
        return match($this) {
            self::FINISH_TO_START => '先行タスクの終了後に開始',
            self::START_TO_START => '先行タスクと同時に開始',
            self::FINISH_TO_FINISH => '先行タスクと同時に終了',
            self::START_TO_FINISH => '先行タスクの開始後に終了',
        };
    }

    /**
     * ガントチャートでの計算に使用する開始日時を取得
     *
     * @param \DateTime $predecessorStart 先行タスクの開始日時
     * @param \DateTime $predecessorFinish 先行タスクの終了日時
     * @param int $lagMinutes 遅延分数（負の値の場合はリード分数）
     * @return \DateTime
     */
    public function calculateStartDate(
        \DateTime $predecessorStart,
        \DateTime $predecessorFinish,
        int $lagMinutes = 0
    ): \DateTime {
        $baseDate = match($this) {
            self::FINISH_TO_START => clone $predecessorFinish,
            self::START_TO_START => clone $predecessorStart,
            self::FINISH_TO_FINISH => clone $predecessorFinish,
            self::START_TO_FINISH => clone $predecessorStart,
        };

        // 分単位で日時を調整
        $interval = new \DateInterval('PT' . abs($lagMinutes) . 'M');
        if ($lagMinutes >= 0) {
            $baseDate->add($interval);
        } else {
            $baseDate->sub($interval);
        }

        return $baseDate;
    }
}