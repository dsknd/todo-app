<?php

namespace App\UseCases;

use App\DataTransferObjects\CreateTaskDTO;
use App\Models\Task;

interface CreateTaskUseCase
{
    /**
     * タスクを作成する
     *
     * @param CreateTaskDTO $dto タスク作成用DTO
     * @return Task 作成されたタスク
     */
    public function execute(CreateTaskDTO $dto): Task;
}