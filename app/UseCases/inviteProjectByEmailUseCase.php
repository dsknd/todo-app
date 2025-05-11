<?php

namespace App\UseCases;

interface InviteProjectByEmailUseCase
{
    /**
     * プロジェクトを招待する
     *
     * @param string $email
     * @param string $projectId
     * @return void
     * @throws InviteProjectByEmailFailedException プロジェクトの招待に失敗した場合
     */
    public function execute(string $email, string $projectId): void;
}