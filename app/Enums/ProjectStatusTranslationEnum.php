<?php

namespace App\Enums;

enum ProjectStatusTranslationEnum: string
{
    /**
     * 日本語の名称
     */
    case PLANNING_JA = '計画中';
    case IN_PROGRESS_JA = '進行中';
    case COMPLETED_JA = '完了';
    case ON_HOLD_JA = '保留中';
    case CANCELLED_JA = 'キャンセル';

    /**
     * 日本語の説明
     */
    case PLANNING_JA_DESCRIPTION = '計画中のプロジェクトです';
    case IN_PROGRESS_JA_DESCRIPTION = '進行中のプロジェクトです';
    case COMPLETED_JA_DESCRIPTION = '完了したプロジェクトです';
    case ON_HOLD_JA_DESCRIPTION = '保留中のプロジェクトです';
    case CANCELLED_JA_DESCRIPTION = 'キャンセルされたプロジェクトです';

    /**
     * 英語の名称
     */
    case PLANNING_EN = 'Planning';
    case IN_PROGRESS_EN = 'In Progress';
    case COMPLETED_EN = 'Completed';
    case ON_HOLD_EN = 'On Hold';
    case CANCELLED_EN = 'Cancelled';

    /**
     * 英語の説明
     */
    case PLANNING_EN_DESCRIPTION = 'Planning project';
    case IN_PROGRESS_EN_DESCRIPTION = 'In Progress project';
    case COMPLETED_EN_DESCRIPTION = 'Completed project';
    case ON_HOLD_EN_DESCRIPTION = 'On Hold project';
    case CANCELLED_EN_DESCRIPTION = 'Cancelled project';

    public static function getJapaneseName(ProjectStatusEnum $status): string
    {
        return match($status) {
            ProjectStatusEnum::PLANNING => self::PLANNING_JA->value,
            ProjectStatusEnum::IN_PROGRESS => self::IN_PROGRESS_JA->value,
            ProjectStatusEnum::COMPLETED => self::COMPLETED_JA->value,
            ProjectStatusEnum::ON_HOLD => self::ON_HOLD_JA->value,
            ProjectStatusEnum::CANCELLED => self::CANCELLED_JA->value,
        };
    }

    public static function getEnglishName(ProjectStatusEnum $status): string    
    {
        return match($status) {
            ProjectStatusEnum::PLANNING => self::PLANNING_EN->value,
            ProjectStatusEnum::IN_PROGRESS => self::IN_PROGRESS_EN->value,
            ProjectStatusEnum::COMPLETED => self::COMPLETED_EN->value,
            ProjectStatusEnum::ON_HOLD => self::ON_HOLD_EN->value,
            ProjectStatusEnum::CANCELLED => self::CANCELLED_EN->value,
        };
    }

    public static function getJapaneseDescription(ProjectStatusEnum $status): string
    {
        return match($status) {
            ProjectStatusEnum::PLANNING => self::PLANNING_JA_DESCRIPTION->value,
            ProjectStatusEnum::IN_PROGRESS => self::IN_PROGRESS_JA_DESCRIPTION->value,
            ProjectStatusEnum::COMPLETED => self::COMPLETED_JA_DESCRIPTION->value,
            ProjectStatusEnum::ON_HOLD => self::ON_HOLD_JA_DESCRIPTION->value,
            ProjectStatusEnum::CANCELLED => self::CANCELLED_JA_DESCRIPTION->value,
        };
    }

    public static function getEnglishDescription(ProjectStatusEnum $status): string
    {
        return match($status) {
            ProjectStatusEnum::PLANNING => self::PLANNING_EN_DESCRIPTION->value,
            ProjectStatusEnum::IN_PROGRESS => self::IN_PROGRESS_EN_DESCRIPTION->value,
            ProjectStatusEnum::COMPLETED => self::COMPLETED_EN_DESCRIPTION->value,
            ProjectStatusEnum::ON_HOLD => self::ON_HOLD_EN_DESCRIPTION->value,
            ProjectStatusEnum::CANCELLED => self::CANCELLED_EN_DESCRIPTION->value,
        };
    }
    
    public static function getName(ProjectStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($status),
            LocaleEnum::ENGLISH => self::getEnglishName($status),
        };
    }

    public static function getDescription(ProjectStatusEnum $status, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($status),
            LocaleEnum::ENGLISH => self::getEnglishDescription($status),
        };
    }
} 
