<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PLANNING()
 * @method static static IN_PROGRESS()
 * @method static static COMPLETED()
 * @method static static ON_HOLD()
 * @method static static CANCELLED()
 */
enum ProjectStatusEnum: int
{
    case PLANNING = 1;      // 計画中
    case IN_PROGRESS = 2;   // 進行中
    case COMPLETED = 3;     // 完了
    case ON_HOLD = 4;       // 保留中
    case CANCELLED = 5;     // キャンセル

    /**
     * システム内部で使用するキーを取得します。
     */
    public static function getKey(self $projectStatus): string
    {
        return match ($projectStatus) {
            self::PLANNING => 'planning',
            self::IN_PROGRESS => 'in_progress',
            self::COMPLETED => 'completed',
            self::ON_HOLD => 'on_hold',
            self::CANCELLED => 'cancelled',
        };
    }
}

