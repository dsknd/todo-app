<?php

namespace App\Enums;

enum ErrorMessageEnum: string
{
    // Repository
    case DUPLICATE_PROJECT_NAME = 'Duplicate project name';
    case PROJECT_NOT_FOUND = 'Project not found';

    // UseCase
    case CREATE_PROJECT_FAILURE = 'Failed to create project';
}
