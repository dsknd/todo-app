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
use App\Repositories\Exceptions\DuplicateProjectNameException;
use App\UseCases\Exceptions\CreateProjectFailureException;
use App\Enums\ErrorCodeEnum;
use Exception;
use App\ValueObjects\UserId;

class CreateProjectInteractor implements CreateProjectUseCase
{
    private ProjectRepository $projectRepository;
    private ProjectMemberRepository $projectMemberRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        ProjectMemberRepository $projectMemberRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectMemberRepository = $projectMemberRepository;
    }

    /**
     * inherit-doc
     */
    public function execute(CreateProjectDto $dto): Project
    {
        return DB::transaction(function () use ($dto) {
            try {
                $project = $this->_createProject($dto);
                $this->_createProjectMember($project, $dto->userId);
                return $project;
            } catch (DuplicateProjectNameException $e) {
                throw new CreateProjectFailureException(ErrorCodeEnum::DUPLICATE_PROJECT_NAME, $e);
            } catch (Exception $e) {
                throw new CreateProjectFailureException(ErrorCodeEnum::UNKNOWN, $e);
            }
        });
    }

    /**
     * プロジェクトを作成
     */
    private function _createProject(CreateProjectDto $dto): Project
    {
        $attributes = $dto->toArray();
        return $this->projectRepository->create($attributes);
    }

    /**
     * プロジェクトメンバーを作成
     */
    private function _createProjectMember(Project $project, UserId $userId): void
    {
        $projectId = $project->id;
        $projectRoleId = ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER);
        $this->projectMemberRepository->add($projectId,$userId,$projectRoleId);
    }
}
