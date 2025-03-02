<?php

namespace App\Interactors;

use App\UseCases\Project\CreateProjectUseCase;
use App\ValueObjects\UserId;
use App\ValueObjects\LocaleCode;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use DateTimeImmutable;
use App\Models\ProjectRole;
use App\ValueObjects\DefaultProjectRole;
use App\Models\ProjectRoleAssignment;
class CreateProjectInteractor implements CreateProjectUseCase
{
    public function execute(
        string $name,
        ?string $description,
        UserId $userId,
        bool $isPrivate,
        ?DateTimeImmutable $plannedStartDate,
        ?DateTimeImmutable $plannedEndDate,
        LocaleCode $localeCode
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
            // プロジェクトを作成
            $project = Project::create([
                'name' => $name,
                'description' => $description,
                'user_id' => $userId->getId(),
                'is_private' => $isPrivate,
                'planned_start_date' => $plannedStartDate,
                'planned_end_date' => $plannedEndDate,
            ]);

            // デフォルトロールを作成
            foreach (DefaultProjectRole::all() as $defaultProjectRole) {
                ProjectRole::create([
                    'project_id' => $project->id,
                    'user_id' => $userId->getId(),
                    'name' => $defaultProjectRole->getLocalizedName($localeCode),
                    'description' => $defaultProjectRole->getLocalizedDescription($localeCode),
                ]);
            }

            // オーナーロールをユーザに割当
            ProjectRoleAssignment::create([
                'project_id' => $project->id,
                'project_role_id' => $defaultProjectRole->getId(),
                'assigner_user_id' => $userId->getId(),
                'assigned_user_id' => $userId->getId(),
            ]);

            // プロジェクトを返す
            return $project;
        });

        // プロジェクトを返す
        return $project;
    }
}