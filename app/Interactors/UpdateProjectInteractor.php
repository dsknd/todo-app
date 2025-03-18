<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\UpdateProjectUseCase;
use App\ValueObjects\ProjectId;

final class UpdateProjectInteractor implements UpdateProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    public function execute(ProjectId $projectId, array $attributes): bool
    {
        return $this->projectRepository->update($projectId, $attributes);
    }
} 