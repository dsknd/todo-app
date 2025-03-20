<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\UpdateProjectUseCase;
use App\ValueObjects\ProjectId;
use App\DataTransferObjects\UpdateProjectDto;
use App\Models\Project;

final class UpdateProjectInteractor implements UpdateProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    public function execute(ProjectId $projectId, UpdateProjectDto $dto): ?Project
    {
        if ($dto->isEmpty()) {
            $project = $this->projectRepository->findById($projectId);
            if (!$project) {
                return null;
            }
            return $project;
        }
        $this->projectRepository->update($projectId, $dto->toArray());
        return $this->projectRepository->findById($projectId);
    }
} 