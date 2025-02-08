<?php

namespace App\Enums;

enum TagAssignmentTypeEnum: int
{
    case ADDED = 1;     // タグが追加された
    case REMOVED = 2;   // タグが削除された

    public static function getKey(self $type): string
    {
        return match($type) {
            self::ADDED => 'ADDED',
            self::REMOVED => 'REMOVED',
        };
    }
} 