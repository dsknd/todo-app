<?php

namespace App\Enums;

enum MilestoneDependencyTypeEnum: int
{
    case REQUIRED = 1;
    case OPTIONAL = 2;

    public static function getKey(self $type): string
    {
        return match($type) {
            self::REQUIRED => 'REQUIRED',
            self::OPTIONAL => 'OPTIONAL',
        };
    }
} 