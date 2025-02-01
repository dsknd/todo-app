<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static WORK()
 * @method static static PERSONAL()
 * @method static static STUDY()
 * @method static static HOBBY()
 * @method static static OTHER()
 */
enum CategoryEnum: int
{
    case WORK = 1;         // 仕事
    case PERSONAL = 2;     // 個人
    case STUDY = 3;        // 学習
    case HOBBY = 4;        // 趣味
    case OTHER = 5;        // その他

    public static function getDisplayName(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            1 => '仕事',
            2 => '個人',
            3 => '学習',
            4 => '趣味',
            5 => 'その他',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }

    public static function getDescription(mixed $value): string
    {
        $value = $value instanceof self ? $value->value : $value;

        return match($value) {
            1 => '仕事関連のカテゴリ',
            2 => '個人的なタスクのカテゴリ',
            3 => '学習・研究に関するカテゴリ',
            4 => '趣味に関するカテゴリ',
            5 => 'その他のカテゴリ',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }
}