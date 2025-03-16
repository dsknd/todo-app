<?php

namespace App\Interactors;

use App\UseCases\CreateTaskUseCase;
use App\DataTransferObjects\CreateTaskDTO;
use App\Models\Task;
use App\Exceptions\ProjectNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UnauthorizedAccessException;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\TaskRepository;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\Interfaces\UserRepository;

class CreateTaskInteractor implements CreateTaskUseCase
{
    /**
     * @param TaskRepository $taskRepository
     * @param ProjectRepository $projectRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        private TaskRepository $taskRepository,
        private ProjectRepository $projectRepository,
        private UserRepository $userRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(CreateTaskDTO $dto): Task
    {
        // プロジェクトの存在確認
        $project = $this->projectRepository->findById($dto->projectId);
        if (!$project) {
            throw new ProjectNotFoundException("プロジェクトが見つかりません: {$dto->projectId}");
        }

        // ユーザーの存在確認
        $user = $this->userRepository->findById($dto->userId);
        if (!$user) {
            throw new UserNotFoundException("ユーザーが見つかりません: {$dto->userId}");
        }

        // プロジェクトへのアクセス権確認
        if (!$this->projectRepository->canUserAccessProject($dto->userId, $dto->projectId)) {
            throw new UnauthorizedAccessException("このプロジェクトにアクセスする権限がありません");
        }

        // トランザクション開始
        return DB::transaction(function () use ($dto) {
            // タスクの作成
            $task = $this->taskRepository->create([
                'title' => $dto->title,
                'description' => $dto->description,
                'project_id' => $dto->projectId->getValue(),
                'user_id' => $dto->userId->getValue(),
                'category_id' => $dto->categoryId->getValue(),
                'priority_id' => $dto->priorityId->getValue(),
                'is_private' => $dto->isPrivate,
                'planned_start_date' => $dto->plannedStartDate,
                'planned_end_date' => $dto->plannedEndDate,
                'actual_start_date' => $dto->actualStartDate,
                'actual_end_date' => $dto->actualEndDate,
            ]);

            return $task;
        });
    }
}