<?php

namespace App\Interactors;

use App\Models\ProjectRole;
use App\UseCases\ProjectRole\CreateDefaultProjectRoleUseCase;
use App\ValueObjects\DefaultProjectRole;
use App\ValueObjects\LocaleCode;
use Illuminate\Support\Facades\DB;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;

class CreateDefaultProjectRoleInteractor implements CreateDefaultProjectRoleUseCase
{

    /**
     * デフォルトのプロジェクトロールを作成する
     *
     * @param ProjectId $projectId プロジェクトID
     * @param DefaultProjectRoleValueObject $roleValueObject 作成するロール
     * @param LocaleValueObject $locale ロケール
     * @return void
     */
    public function execute(
        ProjectId $projectId,
        UserId $userId,
        DefaultProjectRole $defaultProjectRole,
        LocaleCode $localeCode
    ): void {
        // トランザクション開始
        DB::transaction(function () use ($projectId, $userId, $defaultProjectRole, $localeCode) {
            // ロールの基本情報を作成
            ProjectRole::create([
                'project_id' => $projectId->getId(),
                'user_id' => $userId->getId(),
                'name' => $defaultProjectRole->getLocalizedName($localeCode),
                'description' => $defaultProjectRole->getLocalizedDescription($localeCode),
            ]);

            // TODO: ロールの権限を作成
            // TODO: デフォルトロールの割当
            // TODO: オーナーロールを作成ユーザに割当
        });
    }
}