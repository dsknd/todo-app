<?php

namespace App\Enums;

/**
 * タスクの重要度を管理するEnum
 * 
 * 値が大きいほど重要度が高くなります：
 * 5: 最重要
 * 4: 重要
 * 3: 普通
 * 2: 低
 * 1: 最低
 */
enum ImportanceLevelEnum: int
{
    case LOWEST = 1;      // 最低
    case LOW = 2;          // 低
    case MEDIUM = 3;       // 普通
    case HIGH = 4;         // 重要
    case HIGHEST = 5;      // 最重要

    public static function getDisplayName(int $value): string
    {
        return match ($value) {
            self::LOWEST->value => '最低',
            self::LOW->value => '低',
            self::MEDIUM->value => '普通',
            self::HIGH->value => '重要',
            self::HIGHEST->value => '最重要',
        };
    }

    public static function getImportanceLevel(int $value): int
    {
        return match ($value) {
            self::LOWEST->value => 10,
            self::LOW->value => 20,
            self::MEDIUM->value => 30,
            self::HIGH->value => 40,
            self::HIGHEST->value => 50,
        };
    }

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::LOWEST->value => '後回しにしても問題ないタスク',
            self::LOW->value => '余裕があれば着手するタスク',
            self::MEDIUM->value => '通常の優先度のタスク',
            self::HIGH->value => '優先的に取り組むべきタスク',
            self::HIGHEST->value => '最優先で取り組むべきタスク',
        };
    }
} 