<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectStatus;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pending', 'description' => 'The project is pending approval.'],
            ['name' => 'In Progress', 'description' => 'The project is currently in progress.'],
            ['name' => 'Completed', 'description' => 'The project has been completed.'],
            ['name' => 'On Hold', 'description' => 'The project is temporarily on hold.'],
            ['name' => 'Cancelled', 'description' => 'The project has been cancelled.'],
        ];

        foreach ($statuses as $status) {
            ProjectStatus::create($status);
        }
    }
}
