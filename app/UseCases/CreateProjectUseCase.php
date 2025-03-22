<?php

namespace App\UseCases;

use App\DataTransferObjects\CreateProjectDto;
use App\Models\Project;

interface CreateProjectUseCase
{
    /**
     * 新しいプロジェクトを作成する
     *
     * @see CreateProjectInteractor 実装クラス
     *
     * @param CreateProjectDto $dto プロジェクトの作成情報
     * @return Project 作成されたプロジェクト
     * @throws Exception 予期しないエラーが発生した場合
     */
    public function execute(
        CreateProjectDto $dto,
    ): Project;
}