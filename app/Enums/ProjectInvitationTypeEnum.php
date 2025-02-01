<?php

namespace App\Enums;

/**
 * プロジェクト招待の種類を管理するEnum
 * 
 * 値が示す意味：
 * 1: メール招待（未登録ユーザーへのメール招待）
 * 2: ユーザー招待（既存ユーザーへの招待）
 */
enum ProjectInvitationTypeEnum: int
{
    case EMAIL = 1;
    case USER = 2;

    public static function getDisplayName(int $value): string
    {
        return match ($value) {
            self::EMAIL->value => 'メール招待',
            self::USER->value => 'ユーザー招待',
        };
    }

    public static function getDescription(int $value): string
    {
        return match ($value) {
            self::EMAIL->value => '未登録ユーザーへのメール招待',
            self::USER->value => '既存ユーザーへの招待',
        };
    }
} 