<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PERSONAL()
 * @method static static PROJECT()
 */
enum OwnershipTypeEnum: int
{
    case PERSONAL = 1;
    case PROJECT = 2;

    public static function getDisplayName(int|self $value): string
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        return match($value) {
            self::PERSONAL->value => '個人',
            self::PROJECT->value => 'プロジェクト',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }

    public static function getDescription(int|self $value): string
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        return match($value) {
            self::PERSONAL->value => '個人所有のリソースを表します',
            self::PROJECT->value => 'プロジェクトに属するリソースを表します',
            default => throw new \ValueError("Invalid value: {$value}"),
        };
    }

}