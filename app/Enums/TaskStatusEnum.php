<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
enum TaskStatusEnum: int
{
    case NOT_STARTED = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;
    case ON_HOLD = 5;
    case REVIEW = 6;
    case REJECTED = 7;

    public static function getDisplayName(mixed $value): string
    {
        return match($value) {
            self::NOT_STARTED => '未開始',
            self::IN_PROGRESS => '進行中',
            self::COMPLETED => '完了',
            self::CANCELLED => 'キャンセル',
            self::ON_HOLD => '保留',
            self::REVIEW => 'レビュー',
            self::REJECTED => '却下',
        };
    }

    public static function getDescription(mixed $value): string
    {
        return match($value) {
            self::NOT_STARTED => '未開始を表す',
            self::IN_PROGRESS => '進行中を表す',
            self::COMPLETED => '完了を表す',
            self::CANCELLED => 'キャンセルを表す',
            self::ON_HOLD => '保留を表す',
            self::REVIEW => 'レビューを表す',
            self::REJECTED => '却下を表す',
        };
    }

    public static function getIcon(mixed $value): string
    {
        return match($value) {
            self::NOT_STARTED => 'fa-solid fa-circle-dot',
            self::IN_PROGRESS => 'fa-solid fa-circle-dot',
            self::COMPLETED => 'fa-solid fa-circle-dot',
        };
    }

    public static function getTextColor(mixed $value): string
    {
        return match($value) {
            self::NOT_STARTED => 'text-gray-500',
            self::IN_PROGRESS => 'text-blue-500',
            self::COMPLETED => 'text-green-500',
            self::CANCELLED => 'text-red-500',
            self::ON_HOLD => 'text-yellow-500',
            self::REVIEW => 'text-purple-500',
            self::REJECTED => 'text-gray-500',
        };
    }

    public static function getBackgroundColor(mixed $value): string
    {
        return match($value) {
            self::NOT_STARTED => 'bg-gray-500',
            self::IN_PROGRESS => 'bg-blue-500',
            self::COMPLETED => 'bg-green-500',
            self::CANCELLED => 'bg-red-500',
            self::ON_HOLD => 'bg-yellow-500',
            self::REVIEW => 'bg-purple-500',
            self::REJECTED => 'bg-gray-500',
        };
    }
}

