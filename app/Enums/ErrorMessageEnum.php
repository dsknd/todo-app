<?php

namespace App\Enums;

enum ErrorMessageEnum: string
{
    case DUPLICATE_PROJECT_NAME = 'Duplicate project name';
    case PROJECT_NOT_FOUND = 'Project not found';
}
