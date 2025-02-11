<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectStatusEnum;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ProjectStatusEnum::cases() as $status) {
            DB::table('project_statuses')->insert([
                'id' => $status->value,
                'key' => ProjectStatusEnum::getKey($status),
            ]);
        }
    }
}
