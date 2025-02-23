<?php

namespace App\Enums;

enum InvitationTypeTranslationEnum: string
{
    case EMAIL_JA = 'メール招待';
    case USER_JA = 'ユーザー招待';

    case EMAIL_EN = 'Email Invitation';
    case USER_EN = 'User Invitation';

    case EMAIL_JA_DESCRIPTION = '未登録ユーザーへのメール招待';
    case USER_JA_DESCRIPTION = '既存ユーザーへの招待';

    case EMAIL_EN_DESCRIPTION = 'Email invitation for unregistered users';
    case USER_EN_DESCRIPTION = 'Invitation to existing users';
    
    public static function getJapaneseName(InvitationType $type): string
    {
        return match($type) {
            InvitationType::EMAIL => self::EMAIL_JA->value,
            InvitationType::USER => self::USER_JA->value,
        };
    }

    public static function getEnglishName(InvitationType $type): string
    {
        return match($type) {
            InvitationType::EMAIL => self::EMAIL_EN->value,
            InvitationType::USER => self::USER_EN->value,
        };
    }

    public static function getJapaneseDescription(InvitationType $type): string
    {
        return match($type) {
            InvitationType::EMAIL => self::EMAIL_JA_DESCRIPTION->value,
            InvitationType::USER => self::USER_JA_DESCRIPTION->value,
        };
    }

    public static function getEnglishDescription(InvitationType $type): string
    {
        return match($type) {
            InvitationType::EMAIL => self::EMAIL_EN_DESCRIPTION->value,
            InvitationType::USER => self::USER_EN_DESCRIPTION->value,
        };
    }

    public static function getName(InvitationType $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($type),
            LocaleEnum::ENGLISH => self::getEnglishName($type),
        };
    }

    public static function getDescription(InvitationType $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($type),
            LocaleEnum::ENGLISH => self::getEnglishDescription($type),
        };
    }
} 