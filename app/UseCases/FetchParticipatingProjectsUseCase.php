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
     * @param UserId $userId
     * @return Collection<int, Project>
     */
    public function execute(UserId $userId): Collection;
} 