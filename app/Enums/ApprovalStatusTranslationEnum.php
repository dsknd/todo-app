<?php

namespace App\Enums;

enum ApprovalStatusTranslationEnum: string
{
    case PENDING_JA = '承認待ち';
    case APPROVED_JA = '承認済み';
    case REJECTED_JA = '却下';
    case CANCELED_JA = '取消';

    case PENDING_DESCRIPTION_JA = '承認待ちです。';
    case APPROVED_DESCRIPTION_JA = '承認済みです。';
    case REJECTED_DESCRIPTION_JA = '却下されました。';
    case CANCELED_DESCRIPTION_JA = '取消されました。';

    case PENDING_EN = 'Pending';
    case APPROVED_EN = 'Approved';
    case REJECTED_EN = 'Rejected';
    case CANCELED_EN = 'Canceled';

    case PENDING_DESCRIPTION_EN = 'Pending approval.';
    case APPROVED_DESCRIPTION_EN = 'Approved.';
    case REJECTED_DESCRIPTION_EN = 'Rejected.';
    case CANCELED_DESCRIPTION_EN = 'Canceled.';

    public static function getJapaneseName(ApprovalStatusEnum $status): string
    {
        return match($status) {
            ApprovalStatusEnum::PENDING => self::PENDING_JA->value,
            ApprovalStatusEnum::APPROVED => self::APPROVED_JA->value,
            ApprovalStatusEnum::REJECTED => self::REJECTED_JA->value,
            ApprovalStatusEnum::CANCELED => self::CANCELED_JA->value,
        };
    }

    public static function getJapaneseDescription(ApprovalStatusEnum $status): string
    {
        return match($status) {
            ApprovalStatusEnum::PENDING => self::PENDING_DESCRIPTION_JA->value,
            ApprovalStatusEnum::APPROVED => self::APPROVED_DESCRIPTION_JA->value,
            ApprovalStatusEnum::REJECTED => self::REJECTED_DESCRIPTION_JA->value,
            ApprovalStatusEnum::CANCELED => self::CANCELED_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishName(ApprovalStatusEnum $status): string
    {
        return match($status) {
            ApprovalStatusEnum::PENDING => self::PENDING_EN->value,
            ApprovalStatusEnum::APPROVED => self::APPROVED_EN->value,
            ApprovalStatusEnum::REJECTED => self::REJECTED_EN->value,
            ApprovalStatusEnum::CANCELED => self::CANCELED_EN->value,
        };
    }

    public static function getEnglishDescription(ApprovalStatusEnum $status): string
    {
        return match($status) {
            ApprovalStatusEnum::PENDING => self::PENDING_DESCRIPTION_EN->value,
            ApprovalStatusEnum::APPROVED => self::APPROVED_DESCRIPTION_EN->value,
            ApprovalStatusEnum::REJECTED => self::REJECTED_DESCRIPTION_EN->value,
            ApprovalStatusEnum::CANCELED => self::CANCELED_DESCRIPTION_EN->value,
        };
    }

    public static function getName(ApprovalStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($status),
            LocaleEnum::ENGLISH => self::getEnglishName($status),
        };
    }

    public static function getDescription(ApprovalStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($status),
            LocaleEnum::ENGLISH => self::getEnglishDescription($status),
        };
    }
} 