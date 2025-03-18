<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;

interface DeleteProjectUseCase
{
    /**
     * プロジェクトを削除します
     *
     * @param ProjectId $projectId
     * @return bool
     */
    public function execute(ProjectId $projectId): bool;
} 