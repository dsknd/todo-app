<?php

namespace App\Enums;

enum InvitationStatusTranslationEnum: string
{
    case PENDING_JA = '保留中';
    case ACCEPTED_JA = '承諾';
    case DECLINED_JA = '辞退';
    case EXPIRED_JA = '期限切れ';
    case CANCELED_JA = '取消';

    case PENDING_DESCRIPTION_JA = '招待が保留中です。';
    case ACCEPTED_DESCRIPTION_JA = '招待が承諾されました。';
    case DECLINED_DESCRIPTION_JA = '招待が辞退されました。';
    case EXPIRED_DESCRIPTION_JA = '招待の有効期限が切れました。';
    case CANCELED_DESCRIPTION_JA = '招待がキャンセルされました。';

    case PENDING_EN = 'Pending';
    case ACCEPTED_EN = 'Accepted';
    case DECLINED_EN = 'Declined';
    case EXPIRED_EN = 'Expired';
    case CANCELED_EN = 'Canceled';

    case PENDING_DESCRIPTION_EN = 'The invitation is pending.';
    case ACCEPTED_DESCRIPTION_EN = 'The invitation has been accepted.';
    case DECLINED_DESCRIPTION_EN = 'The invitation has been declined.';
    case EXPIRED_DESCRIPTION_EN = 'The invitation has expired.';
    case CANCELED_DESCRIPTION_EN = 'The invitation has been canceled.';

    public static function getJapaneseName(InvitationStatusEnum $status): string
    {
        return match($status) {
            InvitationStatusEnum::PENDING => self::PENDING_JA->value,
            InvitationStatusEnum::ACCEPTED => self::ACCEPTED_JA->value,
            InvitationStatusEnum::DECLINED => self::DECLINED_JA->value,
            InvitationStatusEnum::EXPIRED => self::EXPIRED_JA->value,
            InvitationStatusEnum::CANCELED => self::CANCELED_JA->value,
        };
    }

    public static function getJapaneseDescription(InvitationStatusEnum $status): string
    {
        return match($status) {
            InvitationStatusEnum::PENDING => self::PENDING_DESCRIPTION_JA->value,
            InvitationStatusEnum::ACCEPTED => self::ACCEPTED_DESCRIPTION_JA->value,
            InvitationStatusEnum::DECLINED => self::DECLINED_DESCRIPTION_JA->value,
            InvitationStatusEnum::EXPIRED => self::EXPIRED_DESCRIPTION_JA->value,
            InvitationStatusEnum::CANCELED => self::CANCELED_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishName(InvitationStatusEnum $status): string
    {
        return match($status) {
            InvitationStatusEnum::PENDING => self::PENDING_EN->value,
            InvitationStatusEnum::ACCEPTED => self::ACCEPTED_EN->value,
            InvitationStatusEnum::DECLINED => self::DECLINED_EN->value,
            InvitationStatusEnum::EXPIRED => self::EXPIRED_EN->value,
            InvitationStatusEnum::CANCELED => self::CANCELED_EN->value,
        };
    }

    public static function getEnglishDescription(InvitationStatusEnum $status): string
    {
        return match($status) {
            InvitationStatusEnum::PENDING => self::PENDING_DESCRIPTION_EN->value,
            InvitationStatusEnum::ACCEPTED => self::ACCEPTED_DESCRIPTION_EN->value,
            InvitationStatusEnum::DECLINED => self::DECLINED_DESCRIPTION_EN->value,
            InvitationStatusEnum::EXPIRED => self::EXPIRED_DESCRIPTION_EN->value,
            InvitationStatusEnum::CANCELED => self::CANCELED_DESCRIPTION_EN->value,
        };
    }

    public static function getName(InvitationStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($status),
            LocaleEnum::ENGLISH => self::getEnglishName($status),
        };
    }

    public static function getDescription(InvitationStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($status),
            LocaleEnum::ENGLISH => self::getEnglishDescription($status),
        };
    }
}
