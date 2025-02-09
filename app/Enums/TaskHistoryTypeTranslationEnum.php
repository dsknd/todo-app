<?php

namespace App\Enums;

enum TaskHistoryTypeTranslationEnum: string
{

    /**
     * 日本語の名称を取得
     */
    public static function getJapaneseName(TaskHistoryTypeEnum $type): string
    {
        return match ($type) {
            TaskHistoryTypeEnum::TITLE => 'タイトル変更',
            TaskHistoryTypeEnum::DESCRIPTION => '詳細変更',
            TaskHistoryTypeEnum::STATUS => 'ステータス変更',
            TaskHistoryTypeEnum::PLANNED_SCHEDULE => '予定日時変更',
            TaskHistoryTypeEnum::ACTUAL_SCHEDULE => '実績日時変更',
            TaskHistoryTypeEnum::ASSIGNMENT => '担当者変更',
            TaskHistoryTypeEnum::PRIORITY => '優先度変更',
            TaskHistoryTypeEnum::CATEGORY => 'カテゴリ変更',
            TaskHistoryTypeEnum::TAG => 'タグ変更',
        };
    }

    /**
     * 英語の名称を取得
     */
    public static function getEnglishName(TaskHistoryTypeEnum $type): string
    {
        return match ($type) {
            TaskHistoryTypeEnum::TITLE => 'Title Changed',
            TaskHistoryTypeEnum::DESCRIPTION => 'Description Changed',
            TaskHistoryTypeEnum::STATUS => 'Status Changed',
            TaskHistoryTypeEnum::PLANNED_SCHEDULE => 'Planned Schedule Changed',
            TaskHistoryTypeEnum::ACTUAL_SCHEDULE => 'Actual Schedule Changed',
            TaskHistoryTypeEnum::ASSIGNMENT => 'Assignment Changed',
            TaskHistoryTypeEnum::PRIORITY => 'Priority Changed',
            TaskHistoryTypeEnum::CATEGORY => 'Category Changed',
            TaskHistoryTypeEnum::TAG => 'Tag Changed',
        };
    }

    /**
     * 日本語の説明を取得
     */
    public static function getJapaneseDescription(TaskHistoryTypeEnum $type): string
    {
        return match ($type) {
            TaskHistoryTypeEnum::TITLE => 'タスクのタイトルが変更された履歴',
            TaskHistoryTypeEnum::DESCRIPTION => 'タスクの詳細が変更された履歴',
            TaskHistoryTypeEnum::STATUS => 'タスクのステータスが変更された履歴',
            TaskHistoryTypeEnum::PLANNED_SCHEDULE => 'タスクの予定日時が変更された履歴',
            TaskHistoryTypeEnum::ACTUAL_SCHEDULE => 'タスクの実績日時が変更された履歴',
            TaskHistoryTypeEnum::ASSIGNMENT => 'タスクの担当者が変更された履歴',
            TaskHistoryTypeEnum::PRIORITY => 'タスクの優先度が変更された履歴',
            TaskHistoryTypeEnum::CATEGORY => 'タスクのカテゴリが変更された履歴',
            TaskHistoryTypeEnum::TAG => 'タスクのタグが変更された履歴',
        };
    }

    /**
     * 英語の説明を取得
     */
    public static function getEnglishDescription(TaskHistoryTypeEnum $type): string
    {
        return match ($type) {
            TaskHistoryTypeEnum::TITLE => 'The history of the task title being changed',
            TaskHistoryTypeEnum::DESCRIPTION => 'The history of the task description being changed',
            TaskHistoryTypeEnum::STATUS => 'The history of the task status being changed',
            TaskHistoryTypeEnum::PLANNED_SCHEDULE => 'The history of the task planned schedule being changed',
            TaskHistoryTypeEnum::ACTUAL_SCHEDULE => 'The history of the task actual schedule being changed',
            TaskHistoryTypeEnum::ASSIGNMENT => 'The history of the task assignment being changed',
            TaskHistoryTypeEnum::PRIORITY => 'The history of the task priority being changed',
            TaskHistoryTypeEnum::CATEGORY => 'The history of the task category being changed',
            TaskHistoryTypeEnum::TAG => 'The history of the task tag being changed',
        };
    }

    /**
     * 指定された言語の名称を取得
     */
    public static function getLocalizedName(TaskHistoryTypeEnum $type, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($type),
            LocaleEnum::ENGLISH => self::getEnglishName($type),
        };
    }

    /**
     * 指定された言語の説明を取得
     */
    public static function getLocalizedDescription(TaskHistoryTypeEnum $type, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($type),
            LocaleEnum::ENGLISH => self::getEnglishDescription($type),
        };
    }
} 