<?php

namespace App\UseCases\ProjectRole;

use App\ValueObjects\DefaultProjectRole;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;

interface CreateDefaultProjectRoleUseCase
{
    /**
     * デフォルトのプロジェクトロールを作成する
     *
     * @param ProjectId $projectId プロジェクトID
     * @param UserId $userId ユーザID
     * @param DefaultProjectRole $defaultProjectRole 作成するロール
     * @param LocaleCode $localeCode デフォルトロールのnameとdescriptionのロケール
     * @return void
     * @throws \Exception ロールの作成に失敗した場合
     */
    public function execute(
        ProjectId $projectId,
        UserId $userId,
        DefaultProjectRole $defaultProjectRole,
        LocaleCode $localeCode
    ): void;
}