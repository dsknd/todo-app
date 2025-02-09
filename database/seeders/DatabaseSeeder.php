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
            ImportanceLevelSeeder::class,
            UrgencyLevelSeeder::class,
            TaskAssignmentTypeSeeder::class,
            TagAssignmentTypeSeeder::class,
            PermissionSeeder::class,
            ProjectStatusSeeder::class,
            ProjectInvitationTypeSeeder::class,
            ProjectInvitationStatusSeeder::class,
            ProjectPermissionSeeder::class,
            TaskStatusSeeder::class,
            TaskStatusTranslationSeeder::class,
            TaskHistoryTypeTranslationSeeder::class,
            MilestoneDependencyTypeSeeder::class,
        ]);
    }
}
