<?php

namespace Database\Seeders;

use App\Models\OwnershipType;
use Illuminate\Database\Seeder;
use App\Enums\OwnershipTypeEnum;

class OwnershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (OwnershipTypeEnum::cases() as $type) {
            OwnershipType::create([
                'id' => $type->value,
                'display_name' => OwnershipTypeEnum::getDisplayName($type->value),
                'description' => OwnershipTypeEnum::getDescription($type->value),
            ]);
        }
    }
}
