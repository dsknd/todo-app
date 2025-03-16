<?php

namespace App\UseCases;

use App\Models\Project;
use App\ValueObjects\ProjectId;

interface FindProjectUseCase
{
    public function execute(ProjectId $projectId): ?Project;
} 