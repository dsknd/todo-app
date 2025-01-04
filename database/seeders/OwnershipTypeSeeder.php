<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OwnershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('ownership_types')->insert([
            [
                'name' => 'Personal',
                'description' => 'Tasks owned personally by the user.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Project',
                'description' => 'Tasks associated with a specific project.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
