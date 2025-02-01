<?php

namespace App\Enums;

/**
 * タスクステータスの翻訳を管理するEnum
 */
enum TaskStatusTranslationEnum: int
{
    /**
     * 日本語の名称を取得
     */
    public static function getJapaneseName(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::NOT_STARTED => '未着手',
            TaskStatusEnum::IN_PROGRESS => '進行中',
            TaskStatusEnum::COMPLETED => '完了',
            TaskStatusEnum::ON_HOLD => '保留中',
            TaskStatusEnum::CANCELLED => '中止',
        };
    }

    /**
     * 英語の名称を取得
     */
    public static function getEnglishName(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::NOT_STARTED => 'Not Started',
            TaskStatusEnum::IN_PROGRESS => 'In Progress',
            TaskStatusEnum::COMPLETED => 'Completed',
            TaskStatusEnum::ON_HOLD => 'On Hold',
            TaskStatusEnum::CANCELLED => 'Cancelled',
        };
    }

    /**
     * 日本語の説明を取得
     */
    public static function getJapaneseDescription(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::NOT_STARTED => 'タスクがまだ開始されていない状態',
            TaskStatusEnum::IN_PROGRESS => 'タスクが現在進行中の状態',
            TaskStatusEnum::COMPLETED => 'タスクが完了した状態',
            TaskStatusEnum::ON_HOLD => 'タスクが一時的に保留されている状態',
            TaskStatusEnum::CANCELLED => 'タスクが中止された状態',
        };
    }

    /**
     * 英語の説明を取得
     */
    public static function getEnglishDescription(TaskStatusEnum $status): string
    {
        return match ($status) {
            TaskStatusEnum::NOT_STARTED => 'Task has not been started yet',
            TaskStatusEnum::IN_PROGRESS => 'Task is currently in progress',
            TaskStatusEnum::COMPLETED => 'Task has been completed',
            TaskStatusEnum::ON_HOLD => 'Task is temporarily on hold',
            TaskStatusEnum::CANCELLED => 'Task has been cancelled',
        };
    }

    /**
     * 指定された言語の名称を取得
     */
    public static function getLocalizedName(TaskStatusEnum $status, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseName($status),
            LocaleEnum::ENGLISH => self::getEnglishName($status),
        };
    }

    /**
     * 指定された言語の説明を取得
     */
    public static function getLocalizedDescription(TaskStatusEnum $status, LocaleEnum $locale): string
    {
        return match ($locale) {
            LocaleEnum::JAPANESE => self::getJapaneseDescription($status),
            LocaleEnum::ENGLISH => self::getEnglishDescription($status),
        };
    }   
} 