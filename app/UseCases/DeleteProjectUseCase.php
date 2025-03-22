<?php

namespace App\UseCases;

use App\ValueObjects\ProjectId;
use App\Interactors\DeleteProjectInteractor;
use App\Exceptions\ProjectNotFoundException;
interface DeleteProjectUseCase
{
    /**
     * プロジェクトを削除します
     * 
     * @see DeleteProjectInteractor 実装クラス
     *
     * @param ProjectId $projectId
     * @return bool
     * @throws ProjectNotFoundException
     * @throws Exception
     */
    public function execute(ProjectId $projectId): bool;
} 