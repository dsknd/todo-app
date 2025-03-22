<?php

namespace App\Interactors;

use App\Repositories\Interfaces\ProjectRepository;
use App\UseCases\FetchOwnedProjectsUseCase;
use App\ValueObjects\UserId;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\InternalServerErrorException;
use Throwable;

final class FetchOwnedProjectsInteractor implements FetchOwnedProjectsUseCase
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    /**
     * ユーザーが作成したプロジェクトを取得します
     *
     * @param UserId $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function execute(UserId $userId, int $perPage = 15): LengthAwarePaginator
    {
        try {
            return $this->projectRepository->findByUserId($userId, $perPage);
        } catch (Throwable $e) {
            throw new InternalServerErrorException('Failed to fetch owned projects', $e);
        }
    }
} 