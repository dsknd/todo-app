<?php

namespace App\Enums;

enum ErrorMessageEnum: string
{
    // domain
    case DUPLICATE_PROJECT_NAME = 'Duplicate project name';
    case PROJECT_NOT_FOUND = 'Project not found';
    case PROJECT_MEMBER_NOT_FOUND = 'Project member not found';

    // application
    case CREATE_PROJECT_FAILURE = 'Failed to create project';
    case INVITE_PROJECT_BY_EMAIL_FAILED = 'Failed to invite project by email';
}
