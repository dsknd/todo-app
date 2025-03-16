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
use App\Models\ProjectPermissionAssignment;
use App\Enums\LocaleEnum;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectRoleId;
use App\Enums\DefaultProjectRoleEnum;

class CreateProjectInteractor implements CreateProjectUseCase
{
    private ProjectRepository $projectRepository;
    private ProjectMemberRepository $projectMemberRepository;
    public function __construct(
        ProjectRepository $projectRepository,
        ProjectMemberRepository $projectMemberRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->projectMemberRepository = $projectMemberRepository;
    }

    public function execute(
        string $name,
        ?string $description,
        UserId $userId,
        bool $isPrivate,
        ?DateTimeImmutable $plannedStartDate,
        ?DateTimeImmutable $plannedEndDate,
    ): Project {
        return DB::transaction(function () use (
            $name,
            $description,
            $userId,
            $isPrivate,
            $plannedStartDate,
            $plannedEndDate,
        ) {
            // プロジェクトを作成
            $project = $this->projectRepository->create([
                'name' => $name,
                'description' => $description,
                'user_id' => $userId,
                'project_status_id' => ProjectStatusEnum::PLANNING->value,
                'is_private' => $isPrivate,
                'planned_start_date' => $plannedStartDate,
                'planned_end_date' => $plannedEndDate,
            ]);

            // プロジェクトメンバーを作成
            $this->projectMemberRepository->add(
                $project->id,
                $userId,
                ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER)
            );

            return $project;  // ここでプロジェクトを返す
        });
    }
}