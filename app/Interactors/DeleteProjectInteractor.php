<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\DeleteProjectUseCase;
use App\ValueObjects\ProjectId;
use App\Exceptions\ProjectNotFoundException;
use Exception;

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
        $project = $this->projectRepository->findById($projectId);
    
        if ($project === null) {
            throw new ProjectNotFoundException($projectId);
        }

        return $this->projectRepository->delete($projectId);
    }
} 