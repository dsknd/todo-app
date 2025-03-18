<?php

namespace App\UseCases;

use App\ValueObjects\UserId;
use Illuminate\Pagination\LengthAwarePaginator;

interface FetchOwnedProjectsUseCase
{
    /**
     * ユーザーが作成したプロジェクトを取得します
     *
     * @param UserId $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function execute(UserId $userId, int $perPage = 15): LengthAwarePaginator;
} 