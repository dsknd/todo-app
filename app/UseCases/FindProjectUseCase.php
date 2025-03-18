<?php

namespace App\UseCases;

use App\Models\Project;
use App\ValueObjects\ProjectId;

interface FindProjectUseCase
{
    /**
     * IDによってプロジェクトを検索します
     *
     * @param ProjectId $projectId
     * @return Project|null
     */
    public function execute(ProjectId $projectId): ?Project;
} 