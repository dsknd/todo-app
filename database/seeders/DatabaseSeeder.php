<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $this->call([
            // ロケール
            LocaleSeeder::class,

            // カテゴリ
            CategorySeeder::class,
            CategoryTranslationSeeder::class,

            // 優先度
            PrioritySeeder::class,
            PriorityTranslationSeeder::class,

            // 承認ステータス
            ApprovalStatusSeeder::class,
            ApprovalStatusTranslationSeeder::class,

            // 招待タイプ
            InvitationTypeSeeder::class,
            InvitationTypeTranslationSeeder::class,

            // 招待ステータス
            InvitationStatusSeeder::class,
            InvitationStatusTranslationSeeder::class,

            // スケジュール日時タイプ
            ScheduleDateTypeSeeder::class,

            // タスク割当タイプ
            TaskAssignmentTypeSeeder::class,

            // タグ割当タイプ
            TagAssignmentTypeSeeder::class,

            // パーミッション
            PermissionSeeder::class,
            ProjectPermissionSeeder::class,

            // プロジェクトステータス
            ProjectStatusSeeder::class,
            ProjectStatusTranslationSeeder::class,

            // タスクステータス
            TaskStatusSeeder::class,
            TaskStatusTranslationSeeder::class,

            // タスク履歴
            TaskHistoryTypeSeeder::class,
            TaskHistoryTypeTranslationSeeder::class,

            // マイルストーン
            MilestoneDependencyTypeSeeder::class,
        ]);
    }
}
