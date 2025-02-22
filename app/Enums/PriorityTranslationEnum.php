<?php

namespace App\Enums;

enum PriorityTranslationEnum: string
{
    /**
     * 日本語の名称
     */
    case NONE_JA = '未設定';
    case LOW_JA = '低';
    case MEDIUM_JA = '中';
    case HIGH_JA = '高';
    case CRITICAL_JA = '緊急';

    /**
     * 日本語の説明
     */
    case NONE_JA_DESCRIPTION = '優先度が設定されていません';
    case LOW_JA_DESCRIPTION = '低い優先度です';
    case MEDIUM_JA_DESCRIPTION = '中程度の優先度です';
    case HIGH_JA_DESCRIPTION = '高い優先度です';
    case CRITICAL_JA_DESCRIPTION = '緊急の優先度です';

    /**
     * 英語の名称
     */
    case NONE_EN = 'None';
    case LOW_EN = 'Low';
    case MEDIUM_EN = 'Medium';
    case HIGH_EN = 'High';
    case CRITICAL_EN = 'Critical';

    /**
     * 英語の説明
     */
    case NONE_EN_DESCRIPTION = 'No priority is set for the task';
    case LOW_EN_DESCRIPTION = 'Low priority';
    case MEDIUM_EN_DESCRIPTION = 'Medium priority';
    case HIGH_EN_DESCRIPTION = 'High priority';
    case CRITICAL_EN_DESCRIPTION = 'Critical priority';

    public static function getJapaneseName(PriorityEnum $priority): string
    {
        return match($priority) {
            PriorityEnum::NONE => self::NONE_JA->value,
            PriorityEnum::LOW => self::LOW_JA->value,
            PriorityEnum::MEDIUM => self::MEDIUM_JA->value,
            PriorityEnum::HIGH => self::HIGH_JA->value,
            PriorityEnum::CRITICAL => self::CRITICAL_JA->value,
        };
    }

    public static function getEnglishName(PriorityEnum $priority): string
    {
        return match($priority) {
            PriorityEnum::NONE => self::NONE_EN->value,
            PriorityEnum::LOW => self::LOW_EN->value,
            PriorityEnum::MEDIUM => self::MEDIUM_EN->value,
            PriorityEnum::HIGH => self::HIGH_EN->value,
            PriorityEnum::CRITICAL => self::CRITICAL_EN->value,
        };
    }

    public static function getJapaneseDescription(PriorityEnum $priority): string
    {
        return match($priority) {
            PriorityEnum::NONE => self::NONE_JA_DESCRIPTION->value,
            PriorityEnum::LOW => self::LOW_JA_DESCRIPTION->value,
            PriorityEnum::MEDIUM => self::MEDIUM_JA_DESCRIPTION->value,
            PriorityEnum::HIGH => self::HIGH_JA_DESCRIPTION->value,
            PriorityEnum::CRITICAL => self::CRITICAL_JA_DESCRIPTION->value,
        };
    }

    public static function getEnglishDescription(PriorityEnum $priority): string
    {
        return match($priority) {
            PriorityEnum::NONE => self::NONE_EN_DESCRIPTION->value,
            PriorityEnum::LOW => self::LOW_EN_DESCRIPTION->value,
            PriorityEnum::MEDIUM => self::MEDIUM_EN_DESCRIPTION->value,
            PriorityEnum::HIGH => self::HIGH_EN_DESCRIPTION->value,
            PriorityEnum::CRITICAL => self::CRITICAL_EN_DESCRIPTION->value,
        };
    }

    public static function getName(PriorityEnum $priority, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($priority),
            LocaleEnum::ENGLISH => self::getEnglishName($priority),
        };
    }

    public static function getDescription(PriorityEnum $priority, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($priority),
            LocaleEnum::ENGLISH => self::getEnglishDescription($priority),
        };
    }
} 
