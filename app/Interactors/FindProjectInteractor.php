<?php

namespace App\Interactors;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\FindProjectUseCase;
use App\ValueObjects\ProjectId;

final class FindProjectInteractor implements FindProjectUseCase
{
    private ProjectRepository $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository,
    ) {
        $this->projectRepository = $projectRepository;
    }

    /**
     * プロジェクトをIDで検索します
     *
     * @param ProjectId $projectId
     * @return Project|null
     */
    public function execute(ProjectId $projectId): ?Project
    {
        return $this->projectRepository->findById($projectId);
    }
} 