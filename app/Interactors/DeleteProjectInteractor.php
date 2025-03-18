<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\DeleteProjectUseCase;
use App\ValueObjects\ProjectId;

final class DeleteProjectInteractor implements DeleteProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    /**
     * プロジェクトを削除します
     *
     * @param ProjectId $projectId
     * @return bool
     */
    public function execute(ProjectId $projectId): bool
    {
        return $this->projectRepository->delete($projectId);
    }
} 