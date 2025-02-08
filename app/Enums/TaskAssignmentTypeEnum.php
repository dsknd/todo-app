<?php

namespace App\Enums;

enum TaskAssignmentTypeEnum: int
{
    case ADDED = 1;     // 担当者が追加された
    case REMOVED = 2;   // 担当者が削除された
    case CHANGED = 3;   // 担当者が変更された

    public static function getKey(self $type): string
    {
        return match($type) {
            self::ADDED => 'ADDED',
            self::REMOVED => 'REMOVED',
            self::CHANGED => 'CHANGED',
        };
    }
}
