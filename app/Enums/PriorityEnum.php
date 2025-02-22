<?php

namespace App\Enums;

enum PriorityEnum: int
{
    case NONE = 1;        // 未設定
    case LOW = 2;         // 低
    case MEDIUM = 3;      // 中
    case HIGH = 4;        // 高
    case CRITICAL = 5;    // 最重要

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
            self::LOW => 100,
            self::MEDIUM => 200,
            self::HIGH => 300,
            self::CRITICAL => 400,
        };
    }
}