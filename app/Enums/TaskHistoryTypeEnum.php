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
    case IMPORTANCE = 7;  // 重要度変更
    case URGENCY = 8;    // 緊急度変更
    case CATEGORY = 9;    // カテゴリ変更
}
