<?php

namespace App\Enums;

/**
 * 緊急度レベル
 */
enum UrgencyLevelEnum: int
{
    case MINIMAL = 1;
    case LOW = 2;
    case NORMAL = 3;
    case URGENT = 4;
    case IMMEDIATE = 5;

    public static function getDisplayName(int $value): string
    {
        return match ($value) {
            self::MINIMAL->value => '最低',
            self::LOW->value => '低',
            self::NORMAL->value => '普通',
            self::URGENT->value => '急ぎ',
            self::IMMEDIATE->value => '緊急',
        };
    }

    public static function getUrgencyLevel(int $value): int
    {
        return match ($value) {
            self::MINIMAL->value => 10,
            self::LOW->value => 20,
            self::NORMAL->value => 30,
            self::URGENT->value => 40,
            self::IMMEDIATE->value => 50,
        };
    }

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::MINIMAL->value => '時間に余裕のあるタスク',
            self::LOW->value => '緊急性の低いタスク',
            self::NORMAL->value => '通常のスケジュールで進めるタスク',
            self::URGENT->value => '早急な対応が必要なタスク',
            self::IMMEDIATE->value => '直ちに着手が必要なタスク',
        };
    }
} 