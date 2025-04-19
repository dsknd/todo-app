<?php

namespace App\Enums;

enum ErrorCodeEnum: int
{
    case DUPLICATE_PROJECT_NAME = 1001;
    case PROJECT_NOT_FOUND = 1002;

    public function getMessage(): string
    {
        return match($this) {
            self::DUPLICATE_PROJECT_NAME => 'Duplicate project name',
            self::PROJECT_NOT_FOUND => 'Project not found',
        };
    }
}