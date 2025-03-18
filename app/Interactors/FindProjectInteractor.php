<?php

namespace App\Interactors;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\FindProjectUseCase;
use App\ValueObjects\ProjectId;

final class FindProjectInteractor implements FindProjectUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    /**
     * IDによってプロジェクトを検索します
     *
     * @param ProjectId $projectId
     * @return Project|null
     */
    public function execute(ProjectId $projectId): ?Project
    {
        return $this->projectRepository->findById($projectId);
    }
} 