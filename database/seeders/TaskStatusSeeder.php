<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TaskStatusEnum;
use App\Models\TaskStatus;

/**
 * タスクステータスのシーダー
 */
class TaskStatusSeeder extends Seeder
{
    /**
     * データベースシーダーを実行する
     */
    public function run(): void
    {
        DB::transaction(function () {
            foreach (TaskStatusEnum::cases() as $taskStatus) {
                $taskStatus = new TaskStatus();
                $taskStatus->id = $taskStatus->value;
                $taskStatus->display_name = $taskStatus->getDisplayName($taskStatus->value);
                $taskStatus->description = $taskStatus->getDescription($taskStatus->value);
                $taskStatus->save();
            }
        });
    }
}
