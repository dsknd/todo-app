<?php

namespace App\Interactors;

use App\UseCases\CreateProjectUseCase;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Enums\ProjectStatusEnum;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectRoleId;
use App\Enums\DefaultProjectRoleEnum;
use App\DataTransferObjects\CreateProjectDto;
use App\Exceptions\InternalServerErrorException;
use Throwable;

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

    /**
     * inherit-doc
     */
    public function execute(CreateProjectDto $dto): Project {
        DB::beginTransaction();
        try {
            // プロジェクトを作成
            $project = $this->projectRepository->create([
                'name' => $dto->name,
                'description' => $dto->description,
                'user_id' => $dto->userId,
                'project_status_id' => ProjectStatusEnum::PLANNING->value,
                'is_private' => $dto->isPrivate,
                'planned_start_date' => $dto->plannedStartDate,
                'planned_end_date' => $dto->plannedEndDate,
            ]);

            // プロジェクトメンバーを作成
            $this->projectMemberRepository->add(
                $project->id,
                $dto->userId,
                ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER)
            );

            return $project;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new InternalServerErrorException("Failed to create project", $e);
        }
    }
}