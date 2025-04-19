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
use Illuminate\Database\QueryException;
use App\Http\Exceptions\DuplicateProjectNameException;

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
    public function execute(CreateProjectDto $dto): Project
    {
        return DB::transaction(function () use ($dto) {
            try {
                // プロジェクトを作成
                $project = $this->projectRepository->create($dto->toArray());

                // プロジェクトメンバーを作成
                $this->projectMemberRepository->add(
                    $project->id,
                    $dto->userId,
                    ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER)
                );

                return $project;
            } catch (QueryException $e) {
                // 重複エラーの場合は、DuplicateProjectNameExceptionを投げる
                if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'Duplicate entry')) {
                    throw new DuplicateProjectNameException($e);
                }

                // 重複エラー以外の場合は、そのままエラーを投げる
                throw $e;
            }
        });
    }
}