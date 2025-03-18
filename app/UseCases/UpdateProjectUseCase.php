<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;

interface UpdateProjectUseCase
{
    /**
     * プロジェクトを更新します
     *
     * @param ProjectId $projectId
     * @param array $attributes
     * @return bool
     */
    public function execute(ProjectId $projectId, array $attributes): bool;
} 