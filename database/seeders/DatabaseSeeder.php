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
            LocaleSeeder::class,
            CategorySeeder::class,
            PrioritySeeder::class,
            PriorityTranslationSeeder::class,
            InvitationTypeSeeder::class,
            InvitationTypeTranslationSeeder::class,
            InvitationStatusSeeder::class,
            InvitationStatusTranslationSeeder::class,
            TaskAssignmentTypeSeeder::class,
            TagAssignmentTypeSeeder::class,
            PermissionSeeder::class,
            ProjectStatusSeeder::class,
            ProjectStatusTranslationSeeder::class,
            ProjectPermissionSeeder::class,
            TaskStatusSeeder::class,
            TaskStatusTranslationSeeder::class,
            // タスク履歴
            ScheduleDateTypeSeeder::class,
            TaskHistoryTypeSeeder::class,
            TaskHistoryTypeTranslationSeeder::class,
            // マイルストーン
            MilestoneDependencyTypeSeeder::class,
            // タスク承認
            TaskApprovalStatusSeeder::class,
        ]);
    }
}
