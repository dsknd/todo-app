<?php declare(strict_types=1);

namespace App\Enums;

/**
 * タスクステータス
 * @method static static NOT_STARTED()
 * @method static static IN_PROGRESS()
 * @method static static COMPLETED()
 * @method static static ON_HOLD()
 * @method static static CANCELLED()
 */
enum TaskStatusEnum: int
{
    case NOT_STARTED = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;
    case ON_HOLD = 4;
    case CANCELLED = 5;

    public static function getStatuses(): array
    {
        return [
            self::NOT_STARTED,
            self::IN_PROGRESS,
            self::COMPLETED,
            self::ON_HOLD,
            self::CANCELLED,
        ];
    }

    public static function getNextStatuses(self $status): array
    {
        return match($status) {
            self::NOT_STARTED => [self::IN_PROGRESS],
            self::IN_PROGRESS => [self::COMPLETED, self::ON_HOLD, self::CANCELLED],
            self::COMPLETED => [],
            self::ON_HOLD => [self::IN_PROGRESS],
            self::CANCELLED => [],
        };
    }

    public static function canChangeStatus(self $currentStatus, self $nextStatus): bool
    {
        return in_array($nextStatus, self::getNextStatuses($currentStatus));
    }
}

