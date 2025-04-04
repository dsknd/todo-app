<?php

namespace App\Interactors;

use App\UseCases\CreateProjectUseCase;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectRoleId;
use App\Enums\DefaultProjectRoleEnum;
use App\DataTransferObjects\CreateProjectDto;

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
        return DB::transaction(function () use ($dto) {
            // プロジェクトを作成
            $project = $this->projectRepository->create($dto->toArray());

            // プロジェクトメンバーを作成
            $this->projectMemberRepository->add(
                $project->id,
                $dto->userId,
                ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER)
            );

            return $project;
        });
    }
}