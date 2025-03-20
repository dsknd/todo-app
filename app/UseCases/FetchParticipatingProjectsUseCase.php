<?php

namespace App\UseCases;

use App\Models\Project;
use App\ValueObjects\UserId;
use Illuminate\Support\Collection;

interface FetchParticipatingProjectsUseCase
{
    /**
     * ユーザーが参加しているプロジェクトを取得します
     *
     * @see FetchParticipatingProjectsInteractor 実装クラス
     *
     * @param UserId $userId
     * @return Collection<int, Project>
     */
    public function execute(UserId $userId): Collection;
} 