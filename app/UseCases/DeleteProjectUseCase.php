<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\Interactors\DeleteProjectInteractor;

interface DeleteProjectUseCase
{
    /**
     * プロジェクトを削除します
     * 
     * @see DeleteProjectInteractor 実装クラス
     *
     * @param ProjectId $projectId
     * @return bool
     */
    public function execute(ProjectId $projectId): bool;
} 