<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\DeleteProjectUseCase;
use App\ValueObjects\ProjectId;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\InternalServerErrorException;
use Throwable;

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
     * @throws ProjectNotFoundException
     * @throws InternalServerErrorException
     */
    public function execute(ProjectId $projectId): bool
    {
        $project = $this->projectRepository->findById($projectId);
    
        if ($project === null) {
            throw new ProjectNotFoundException($projectId);
        }

        try {
            return $this->projectRepository->delete($projectId);
        } catch (Throwable $e) {
            throw new InternalServerErrorException('Failed to delete project', $e);
        }
    }
} 