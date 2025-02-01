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

    public static function getDisplayName(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            1 => '計画中',
            2 => '進行中',
            3 => '完了',
            4 => '保留中',
            5 => 'キャンセル',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }

    public static function getDescription(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            1 => 'プロジェクトは計画段階です',
            2 => 'プロジェクトは現在進行中です',
            3 => 'プロジェクトは完了しました',
            4 => 'プロジェクトは一時的に保留中です',
            5 => 'プロジェクトはキャンセルされました',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }

    public function getNextStatuses(): array
    {
        return match($this) {
            self::PLANNING => [self::IN_PROGRESS],
            self::IN_PROGRESS => [self::COMPLETED, self::ON_HOLD, self::CANCELLED],
            self::COMPLETED => [],
            self::ON_HOLD => [self::IN_PROGRESS],
            self::CANCELLED => [],
            default => [],
        };
    }
}

