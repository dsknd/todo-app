<?php

namespace App\Enums;

enum ScheduleDateTypeEnum: int
{
    case PLANNED_START_DATE = 1;  // 予定開始日
    case PLANNED_END_DATE = 2;    // 予定終了日
    case ACTUAL_START_DATE = 3;  // 実績開始日
    case ACTUAL_END_DATE = 4;    // 実績終了日
    case DUE_DATE = 5;           // 期限日

    public static function getKey(self $type): string
    {
        return match($type) {
            self::PLANNED_START_DATE => 'PLANNED_START_DATE',
            self::PLANNED_END_DATE => 'PLANNED_END_DATE',
            self::ACTUAL_START_DATE => 'ACTUAL_START_DATE',
            self::ACTUAL_END_DATE => 'ACTUAL_END_DATE',
            self::DUE_DATE => 'DUE_DATE',
        };
    }
} 