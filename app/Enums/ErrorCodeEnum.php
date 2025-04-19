<?php

namespace App\Enums;

enum ErrorCodeEnum: int
{
    // 共通
    case UNKNOWN = 0;

    // プロジェクト
    case DUPLICATE_PROJECT_NAME = 4001;
    case PROJECT_NOT_FOUND = 4002;
}