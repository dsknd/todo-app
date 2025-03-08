<?php

namespace App\Interactors;

use App\UseCases\CreateProjectUseCase;
use App\ValueObjects\UserId;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use DateTimeImmutable;
use App\Models\ProjectRole;
use App\Models\ProjectRoleAssignment;
use App\Enums\ProjectStatusEnum;
use App\Models\ProjectMember;
use App\ValueObjects\LocaleCode;
use App\Enums\DefaultProjectRolePresetEnum;
use App\Models\ProjectPermissionAssignment;
use App\Enums\LocaleEnum;

class CreateProjectInteractor implements CreateProjectUseCase
{
    public function execute(
        string $name,
        ?string $description,
        UserId $userId,
        bool $isPrivate,
        ?DateTimeImmutable $plannedStartDate,
        ?DateTimeImmutable $plannedEndDate,
        ?LocaleCode $localeCode
    ): Project {
        $project = DB::transaction(function () use (
            $name,
            $description,
            $userId,
            $isPrivate,
            $plannedStartDate,
            $plannedEndDate,
            $localeCode
        ) {
            // 現在時間を取得
            $now = now();

            // ロケールコードをEnumに変換
            $locale = $localeCode ?? LocaleEnum::ENGLISH;
            $locale = $localeCode->toEnum();

            // プロジェクトを作成
            $project = Project::create([
                'name' => $name,
                'description' => $description,
                'user_id' => $userId->getId(),
                'project_status_id' => ProjectStatusEnum::PLANNING->value,
                'is_private' => $isPrivate,
                'planned_start_date' => $plannedStartDate,
                'planned_end_date' => $plannedEndDate,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // プロジェクトメンバーを作成
            ProjectMember::create([
                'project_id' => $project->id,
                'user_id' => $userId->getId(),
                'joined_at' => $now,
            ]);

            # デフォルトロールを作成
            foreach (DefaultProjectRolePresetEnum::cases() as $defaultProjectRole)  {
                ProjectRole::create([
                    'project_id' => $project->id,
                    'user_id' => $userId->getId(),
                    'name' => DefaultProjectRolePresetEnum::getName($defaultProjectRole, $locale),
                    'description' => DefaultProjectRolePresetEnum::getDescription($defaultProjectRole, $locale),
                ]);
            }

            // プロジェクトロールに権限を割り当て
            foreach (DefaultProjectRolePresetEnum::cases() as $defaultProjectRole) {
                foreach (DefaultProjectRolePresetEnum::getPermissions($defaultProjectRole) as $projectPermission) {
                    ProjectPermissionAssignment::create([
                        'project_role_id' => $defaultProjectRole->value,
                        'project_permission_id' => $projectPermission,
                        'assigner_id' => $userId->getId(),
                        'assigned_at' => $now,
                    ]);
                }
            }

            // オーナーロールをプロジェクト作成ユーザに割当
            ProjectRoleAssignment::create([
                'project_id' => $project->id,
                'project_role_id' => DefaultProjectRolePresetEnum::OWNER->value,
                'assigner_id' => $userId->getId(),
                'assignee_id' => $userId->getId(),
                'assigned_at' => $now,
            ]);

            // プロジェクトを返す
            return $project;
        });

        // プロジェクトを返す
        return $project;
    }
}