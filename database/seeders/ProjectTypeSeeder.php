<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    public function run()
    {
        User::all()->each(function ($user) {
            ProjectType::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}