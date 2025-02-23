<?php

namespace App\Enums;

enum TaskAssignmentTypeTranslationEnum: string
{
    case ADDED_JA = '担当者追加';
    case REMOVED_JA = '担当者削除';
    case CHANGED_JA = '担当者変更';

    case ADDED_DESCRIPTION_JA = '担当者が追加されました。';
    case REMOVED_DESCRIPTION_JA = '担当者が削除されました。';
    case CHANGED_DESCRIPTION_JA = '担当者が変更されました。';

    case ADDED_EN = 'Assignee Added';
    case REMOVED_EN = 'Assignee Removed';
    case CHANGED_EN = 'Assignee Changed';

    case ADDED_DESCRIPTION_EN = 'The assignee has been added.';
    case REMOVED_DESCRIPTION_EN = 'The assignee has been removed.';
    case CHANGED_DESCRIPTION_EN = 'The assignee has been changed.';

    public static function getJapaneseName(TaskAssignmentTypeEnum $type): string
    {
        return match($type) {
            TaskAssignmentTypeEnum::ADDED => self::ADDED_JA->value,
            TaskAssignmentTypeEnum::REMOVED => self::REMOVED_JA->value,
            TaskAssignmentTypeEnum::CHANGED => self::CHANGED_JA->value,
        };
    }

    public static function getEnglishName(TaskAssignmentTypeEnum $type): string 
    {
        return match($type) {
            TaskAssignmentTypeEnum::ADDED => self::ADDED_EN->value,
            TaskAssignmentTypeEnum::REMOVED => self::REMOVED_EN->value,
            TaskAssignmentTypeEnum::CHANGED => self::CHANGED_EN->value,
        };
    }

    public static function getJapaneseDescription(TaskAssignmentTypeEnum $type): string
    {
        return match($type) {
            TaskAssignmentTypeEnum::ADDED => self::ADDED_DESCRIPTION_JA->value,
            TaskAssignmentTypeEnum::REMOVED => self::REMOVED_DESCRIPTION_JA->value,
            TaskAssignmentTypeEnum::CHANGED => self::CHANGED_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(TaskAssignmentTypeEnum $type): string
    {
        return match($type) {
            TaskAssignmentTypeEnum::ADDED => self::ADDED_DESCRIPTION_EN->value,
            TaskAssignmentTypeEnum::REMOVED => self::REMOVED_DESCRIPTION_EN->value,
            TaskAssignmentTypeEnum::CHANGED => self::CHANGED_DESCRIPTION_EN->value,
        };
    }

    public static function getName(TaskAssignmentTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($type),
            LocaleEnum::ENGLISH => self::getEnglishName($type),
        };
    }

    public static function getDescription(TaskAssignmentTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($type),
            LocaleEnum::ENGLISH => self::getEnglishDescription($type),
        };
    }
}