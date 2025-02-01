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
            foreach (TaskStatusEnum::cases() as $status) {
                DB::table('task_statuses')->insert([
                    'id' => $status->value,
                ]);
            }
        });
    }
}
