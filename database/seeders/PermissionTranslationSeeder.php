<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionEnum;
use App\Enums\LocaleEnum;
use App\Enums\PermissionTranslationEnum;
class PermissionTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (PermissionEnum::cases() as $permission) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('permission_translations')->insert([
                        'permission_id' => $permission->value,
                        'locale_id' => $locale->value,
                        'name' => PermissionTranslationEnum::getName($permission, $locale),
                        'description' => PermissionTranslationEnum::getDescription($permission, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 