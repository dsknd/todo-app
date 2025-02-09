<?php

namespace App\Enums;

enum TaskHistoryTypeEnum: int
{
    case TITLE = 1;       // タイトル変更
    case DESCRIPTION = 2; // 詳細変更
    case STATUS = 3;      // ステータス変更
    case PLANNED_SCHEDULE = 4;    // 予定日時の変更
    case ACTUAL_SCHEDULE = 5;     // 実績日時の変更
    case ASSIGNMENT = 6;    // 担当者変更
    case PRIORITY = 7;      // 優先度変更
    case CATEGORY = 8;    // カテゴリ変更
    case TAG = 9;        // タグの追加/削除
}
