<?php

namespace App\Enums;

enum PriorityEnum: int
{
    case NONE = 0;        // 未設定
    case LOW = 25;         // 低
    case MEDIUM = 50;      // 中
    case HIGH = 75;        // 高
    case CRITICAL = 100;    // 最重要

    public static function getKey(self $type): string
    {
        return match($type) {
            self::NONE => 'NONE',
            self::LOW => 'LOW',
            self::MEDIUM => 'MEDIUM',
            self::HIGH => 'HIGH',
            self::CRITICAL => 'CRITICAL',
        };
    }

    public static function getPriorityValue(self $type): int
    {
        return match($type) {
            self::NONE => 0,
            self::LOW => 25,
            self::MEDIUM => 50,
            self::HIGH => 75,
            self::CRITICAL => 100,
        };
    }
}