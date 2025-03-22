<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\FetchParticipatingProjectsUseCase;
use App\ValueObjects\UserId;
use Illuminate\Pagination\LengthAwarePaginator;
use App\ValueObjects\ProjectOrderParam;
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
     * @param ?int $perPage
     * @param ?ProjectOrderParam $orderParam
     * @return LengthAwarePaginator
     */
    public function execute(UserId $userId, ?int $perPage = 15, ?ProjectOrderParam $orderParam = null): LengthAwarePaginator
    {
        return $this->projectRepository->findByMemberId($userId, $perPage, $orderParam);
    }
} 