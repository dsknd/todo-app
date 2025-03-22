<?php

namespace App\UseCases;

use App\ValueObjects\UserId;
use Illuminate\Pagination\LengthAwarePaginator;
use App\ValueObjects\ProjectOrderParam;

interface FetchParticipatingProjectsUseCase
{
    /**
     * ユーザーが参加しているプロジェクトを取得します
     *
     * @see FetchParticipatingProjectsInteractor 実装クラス
     *
     * @param UserId $userId
     * @param ?int $perPage
     * @param ?ProjectOrderParam $orderParam
     * @return LengthAwarePaginator
     */
    public function execute(UserId $userId, ?int $perPage = 15, ?ProjectOrderParam $orderParam = null): LengthAwarePaginator;
} 