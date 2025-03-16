<?php

namespace App\Enums;

enum DefaultProjectRoleEnum: int
{
    case OWNER = 1;
    case ADMIN = 2;
    case MEMBER = 3;
    case VIEWER = 4;
    case GUEST = 5;

    public static function getKey(self $role): string
    {
        return match ($role) {
            self::OWNER => 'OWNER',
            self::ADMIN => 'ADMIN',
            self::MEMBER => 'MEMBER',
            self::VIEWER => 'VIEWER',
            self::GUEST => 'GUEST',
        };
    }

    public static function getAssignableLimit(self $role): ?int
    {
        return match ($role) {
            self::OWNER => 1,
            self::ADMIN => null,
            self::MEMBER => null,
            self::VIEWER => null,
            self::GUEST => null,
        };
    }
}
