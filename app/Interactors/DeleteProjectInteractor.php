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
     * inherit-doc
     */
    public function execute(ProjectId $projectId): bool
    {
        return $this->projectRepository->delete($projectId);
    }
} 