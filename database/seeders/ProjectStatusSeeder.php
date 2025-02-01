<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectStatus;
use App\Enums\ProjectStatusEnum;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ProjectStatusEnum::cases() as $status) {
            ProjectStatus::create([
                'id' => $status->value,
                'display_name' => ProjectStatusEnum::getDisplayName($status->value),
                'description' => ProjectStatusEnum::getDescription($status->value),
            ]);
        }
    }
}
