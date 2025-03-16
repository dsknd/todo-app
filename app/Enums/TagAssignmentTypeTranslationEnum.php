<?php

namespace App\Enums;

enum TagAssignmentTypeTranslationEnum: string
{
    case ADDED_JA = 'タグ追加';
    case REMOVED_JA = 'タグ削除';

    case ADDED_DESCRIPTION_JA = 'タグが追加されました';
    case REMOVED_DESCRIPTION_JA = 'タグが削除されました';

    case ADDED_EN = 'Added';
    case REMOVED_EN = 'Removed';

    case ADDED_DESCRIPTION_EN = 'Tag was added';
    case REMOVED_DESCRIPTION_EN = 'Tag was removed';

    public static function getJapaneseName(TagAssignmentTypeEnum $type): string
    {
        return match($type) {
            TagAssignmentTypeEnum::ADDED => self::ADDED_JA->value,
            TagAssignmentTypeEnum::REMOVED => self::REMOVED_JA->value,
        };
    }

    public static function getEnglishName(TagAssignmentTypeEnum $type): string
    {
        return match($type) {
            TagAssignmentTypeEnum::ADDED => self::ADDED_EN->value,
            TagAssignmentTypeEnum::REMOVED => self::REMOVED_EN->value,
        };
    }

    public static function getJapaneseDescription(TagAssignmentTypeEnum $type): string
    {
        return match($type) {
            TagAssignmentTypeEnum::ADDED => self::ADDED_DESCRIPTION_JA->value,
            TagAssignmentTypeEnum::REMOVED => self::REMOVED_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(TagAssignmentTypeEnum $type): string
    {
        return match($type) {
            TagAssignmentTypeEnum::ADDED => self::ADDED_DESCRIPTION_EN->value,
            TagAssignmentTypeEnum::REMOVED => self::REMOVED_DESCRIPTION_EN->value,
        };
    }

    public static function getName(TagAssignmentTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($type),
            LocaleEnum::ENGLISH => self::getEnglishName($type),
        };
    }

    public static function getDescription(TagAssignmentTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($type),
            LocaleEnum::ENGLISH => self::getEnglishDescription($type),
        };
    }
} 
