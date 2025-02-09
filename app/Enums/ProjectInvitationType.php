<?php

namespace App\Enums;

enum ProjectInvitationType: int
{
    case EMAIL = 1;          // メールアドレスによる招待
    case USER = 2;         // 既存ユーザーへの直接招待

    public static function getKey(self $type): string
    {
        return match($type) {
            self::EMAIL => 'EMAIL',
            self::USER => 'USER',
        };
    }
} 