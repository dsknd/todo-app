<?php

namespace App\Exceptions;

use App\ValueObjects\ProjectId;
use RuntimeException;

class ProjectNotFoundException extends RuntimeException
{
    public function __construct(ProjectId $projectId)
    {
        parent::__construct(
            sprintf('Project not found: %s', $projectId->getValue())
        );
    }
} 