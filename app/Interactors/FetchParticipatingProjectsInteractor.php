<?php

namespace App\Interactors;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\FetchParticipatingProjectsUseCase;
use App\ValueObjects\UserId;
use Illuminate\Support\Collection;

final class FetchParticipatingProjectsInteractor implements FetchParticipatingProjectsUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    /**
     * ユーザーが参加しているプロジェクトを取得します
     *
     * @param UserId $userId
     * @return Collection<int, Project>
     */
    public function execute(UserId $userId): Collection
    {
        return $this->projectRepository->findByParticipantId($userId);
    }
} 