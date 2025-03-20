<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\DataTransferObjects\UpdateProjectDto;
use App\Models\Project;

interface UpdateProjectUseCase
{
    /**
     * プロジェクトを更新します
     *
     * @see UpdateProjectInteractor 実装クラス
     *
     * @param ProjectId $projectId
     * @param UpdateProjectDto $dto
     * @return ?Project
     */
    public function execute(ProjectId $projectId, UpdateProjectDto $dto): ?Project;
} 