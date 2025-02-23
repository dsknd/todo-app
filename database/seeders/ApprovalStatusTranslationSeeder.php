<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ApprovalStatusEnum;
use App\Enums\LocaleEnum;
use App\Enums\ApprovalStatusTranslationEnum;

class ApprovalStatusTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ApprovalStatusEnum::cases() as $approvalStatus) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('approval_status_translations')->insert([
                        'approval_status_id' => $approvalStatus->value,
                        'locale_id' => $locale->value,
                        'name' => ApprovalStatusTranslationEnum::getName($approvalStatus, $locale),
                        'description' => ApprovalStatusTranslationEnum::getDescription($approvalStatus, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 