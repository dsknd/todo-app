<?php

namespace Database\Seeders;

use App\Enums\OwnershipTypes;
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

        DB::table('ownership_types')->insert([
            [
                'id' => OwnershipTypes::PERSONAL,
                'name' => 'Personal',
                'description' => 'Tasks owned personally by the user.',
            ],
            [
                'id' => OwnershipTypes::PROJECT,
                'name' => 'Project',
                'description' => 'Tasks associated with a specific project.',
            ],
        ]);
    }
}
