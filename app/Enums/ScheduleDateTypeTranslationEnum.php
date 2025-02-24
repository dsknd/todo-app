<?php

namespace App\Enums;

use App\Enums\ScheduleDateTypeEnum;

enum ScheduleDateTypeTranslationEnum: string
{
    case PLANNED_START_DATE_JA = '予定開始日';
    case PLANNED_END_DATE_JA = '予定終了日';
    case ACTUAL_START_DATE_JA = '実績開始日';
    case ACTUAL_END_DATE_JA = '実績終了日';
    case DUE_DATE_JA = '期限日';

    case PLANNED_START_DATE_EN = 'Planned Start Date';
    case PLANNED_END_DATE_EN = 'Planned End Date';
    case ACTUAL_START_DATE_EN = 'Actual Start Date';
    case ACTUAL_END_DATE_EN = 'Actual End Date';
    case DUE_DATE_EN = 'Due Date';

    case PLANNED_START_DATE_DESCRIPTION_JA = 'タスクの予定開始日を示します。';
    case PLANNED_END_DATE_DESCRIPTION_JA = 'タスクの予定終了日を示します。';
    case ACTUAL_START_DATE_DESCRIPTION_JA = 'タスクの実績開始日を示します。';
    case ACTUAL_END_DATE_DESCRIPTION_JA = 'タスクの実績終了日を示します。';
    case DUE_DATE_DESCRIPTION_JA = 'タスクの期限日を示します。';
    
    case PLANNED_START_DATE_DESCRIPTION_EN = 'The planned start date indicates the scheduled start date of the task.';
    case PLANNED_END_DATE_DESCRIPTION_EN = 'The planned end date indicates the scheduled end date of the task.';
    case ACTUAL_START_DATE_DESCRIPTION_EN = 'The actual start date indicates the actual start date of the task.';
    case ACTUAL_END_DATE_DESCRIPTION_EN = 'The actual end date indicates the actual end date of the task.';
    case DUE_DATE_DESCRIPTION_EN = 'The due date indicates the due date of the task.';
    
    public static function getJapaneseName(ScheduleDateTypeEnum $type): string
    {
        return match($type) {
            ScheduleDateTypeEnum::PLANNED_START_DATE => self::PLANNED_START_DATE_JA->value,
            ScheduleDateTypeEnum::PLANNED_END_DATE => self::PLANNED_END_DATE_JA->value,
            ScheduleDateTypeEnum::ACTUAL_START_DATE => self::ACTUAL_START_DATE_JA->value,
            ScheduleDateTypeEnum::ACTUAL_END_DATE => self::ACTUAL_END_DATE_JA->value,
            ScheduleDateTypeEnum::DUE_DATE => self::DUE_DATE_JA->value,
        };
    }

    public static function getEnglishName(ScheduleDateTypeEnum $type): string
    {
        return match($type) {
            ScheduleDateTypeEnum::PLANNED_START_DATE => self::PLANNED_START_DATE_EN->value,
            ScheduleDateTypeEnum::PLANNED_END_DATE => self::PLANNED_END_DATE_EN->value,
            ScheduleDateTypeEnum::ACTUAL_START_DATE => self::ACTUAL_START_DATE_EN->value,
            ScheduleDateTypeEnum::ACTUAL_END_DATE => self::ACTUAL_END_DATE_EN->value,
            ScheduleDateTypeEnum::DUE_DATE => self::DUE_DATE_EN->value,
        };
    }

    public static function getJapaneseDescription(ScheduleDateTypeEnum $type): string
    {
        return match($type) {
            ScheduleDateTypeEnum::PLANNED_START_DATE => self::PLANNED_START_DATE_DESCRIPTION_JA->value,
            ScheduleDateTypeEnum::PLANNED_END_DATE => self::PLANNED_END_DATE_DESCRIPTION_JA->value,
            ScheduleDateTypeEnum::ACTUAL_START_DATE => self::ACTUAL_START_DATE_DESCRIPTION_JA->value,
            ScheduleDateTypeEnum::ACTUAL_END_DATE => self::ACTUAL_END_DATE_DESCRIPTION_JA->value,
            ScheduleDateTypeEnum::DUE_DATE => self::DUE_DATE_DESCRIPTION_JA->value,
        };
    }

    public static function getEnglishDescription(ScheduleDateTypeEnum $type): string
    {
        return match($type) {
            ScheduleDateTypeEnum::PLANNED_START_DATE => self::PLANNED_START_DATE_DESCRIPTION_EN->value,
            ScheduleDateTypeEnum::PLANNED_END_DATE => self::PLANNED_END_DATE_DESCRIPTION_EN->value,
            ScheduleDateTypeEnum::ACTUAL_START_DATE => self::ACTUAL_START_DATE_DESCRIPTION_EN->value,
            ScheduleDateTypeEnum::ACTUAL_END_DATE => self::ACTUAL_END_DATE_DESCRIPTION_EN->value,
            ScheduleDateTypeEnum::DUE_DATE => self::DUE_DATE_DESCRIPTION_EN->value,
        };
    }

    public static function getName(ScheduleDateTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($type),
            LocaleEnum::ENGLISH => self::getEnglishName($type),
        };
    }

    public static function getDescription(ScheduleDateTypeEnum $type, LocaleEnum $locale): string
    {
        return match($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($type),
            LocaleEnum::ENGLISH => self::getEnglishDescription($type),
        };
    }
} 
